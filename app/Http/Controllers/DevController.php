<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Collection;
use \DateTime; // 追加: PHPのグローバルな名前空間にあるDateTimeクラスを使用することを明示
use DateTimeZone;
//model
use App\Models\SatoInstruction;
use App\Models\PlanProduction;
use App\Models\StockIngredient;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

class DevController extends Controller
{
    /**
     * 開発遊び用.
     * トップ
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sample = 0;
        return view('dev/home', compact("sample"));
    }

    /**
     * common_addnote.
     * サト指示共通ページ
     * @param int $flgs
     * @param string $action_message
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function common_addnote($flg_oride, $flg_add, $action_message)
    {

        $mode_inserts = $this->get_select_values('mode_inserts',$flg_oride, $flg_add);
        return view('common_addnote', compact("action_message", "mode_inserts", "flg_oride", "flg_add"));
    }

    /**
     * シフトページ Google スプレッドシートをフレームで表示.
     */
    public function shift_google()
    {
        $action_message = 'シフトページ Google スプレッドシートをフレームで表示';
        return view('shift_google', compact("action_message"));
    }

    /**
     * 
     * サト指示共通登録完了ページ
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function common_addnote_complete(Request $request)
    {
        // Post データ取得
        $inputs = $request->all();
        $mode_insert = $inputs['mode_inserts_list'];

        // Sessionにデータ保持
        \Session::flash('note8h', $inputs['note8h']);
        \Session::flash('note_date', $inputs['note_date']);
        \Session::flash('mode_insert_now', $mode_insert);
        \Session::flash('action_message', $inputs['action_message']);

        /**
         * Table作るの面倒だからサト指示テーブルを使う
         * 上書き/追加 登録
         */               
        $sato_instruction = SatoInstruction::updateOrCreate(
            [
                'aply_date' => $inputs['note_date'],
                'flg_int' => $mode_insert
            ],
            [
                'override_tx_1' => $inputs['note8h'],
            ]
         );

        return view('common_addnote_complete', compact("mode_insert", "sato_instruction"));
    }


    /**
     * select values
     * 追加：　　mode_inserts
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_select_values($s_id, $id_oride, $id_add){

        if($s_id == 'mode_inserts'){
            // select ボックス要素作成
            $mode_inserts = collect([
                ['id' => '', 'name' => ''],
                ['id' => $id_oride, 'name' => '上書き更新'],
                ['id' => $id_add, 'name' => '追加'],
            ]);
            return $mode_inserts;
        }
    }

    /**
     * Execl.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function importCSV()
    {
        $path = public_path('csv/file.csv');
    
        $data = Excel::toArray([], $path, null, \Maatwebsite\Excel\Excel::CSV, [
            'encoding' => 'UTF-8',
            'delimiter' => ',',
            'skip' => 1 // タイトル行をスキップします
        ])[0];
        array_shift($data); // タイトル行を削除
    
        $collection = collect($data);
    
        // グループ化するためのキーを生成するコールバック関数
        $groupKeyCallback = function ($item) use ($collection) {
            $string = $item[1];
            $groupKey = '';
        
            for ($i = 0; $i <= mb_strlen($string) - 10; $i++) {
                $substring = mb_substr($string, $i, 10);
        
                $isSubstringInOtherItems = $collection->filter(function ($otherItem) use ($substring) {
                    $otherString = $otherItem[1];
                    return mb_strpos($otherString, $substring) !== false;
                })->isNotEmpty();
        
                if ($isSubstringInOtherItems) {
                    $groupKey = $substring;
                    break;
                }
            }
        
            return $groupKey;
        };
        
    
        // グループ化されたコレクションを作成
        $groupedCollection = $collection->groupBy($groupKeyCallback);
        // グループ化されたデータを出力
        $groupedCollection = $groupedCollection->map(function ($group) {
            return $group->map(function ($item) {
                return mb_convert_encoding($item, 'UTF-8', 'UTF-8');
            });
        });

        //dd($groupedCollection);
        // csv 出力処理
        $csvData = '';
        foreach ($groupedCollection as $group => $items) {
            $csvData .= "Group: $group\n"; // グループ名の行
            $csvData .= "ID,Name,Group\n"; // ヘッダー行
    
            foreach ($items as $item) {
                $csvData .= implode(',', $item) . "\n"; // データ行 
            }
    
            $csvData .= "\n\n"; // 改行
        }
    
        $filePath = public_path('csv/output.csv');
        file_put_contents($filePath, $csvData);
    
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    /**
     * Execl.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */ 
    public function importCSV2(Request $request, $page_id = null)
    {
        // 処理がタイムアウトするまでの時間を延ばす
        ini_set('max_execution_time', 400);
    
        // view から読み込む
        $file = $request->file('amecanjapan');
    
        // ファイルの保存とパスの取得
        $filePath = $file->store('temp');
    
        // file 読み込み
        $data = array_map('str_getcsv', file(storage_path('app/' . $filePath)));
        array_shift($data); // タイトル行を削除
    
        $collection = collect($data);
        $collection = $collection->map(function ($item) {
            $string = $item[1];
            $katakanaOnly = preg_replace('/[^ァ-ヶー]/u', '', $string); // カタカナのみを抽出
            $katakanaOnly = preg_replace('/\s+/', '', $katakanaOnly); // 空白を削除
    
            $item[] = $katakanaOnly; // 最終列に追加
    
            return $item;
        });
    
        // グループ化するためのキーを生成するコールバック関数
        $groupKeyCallback = function ($item) use ($collection) {
            $enditemindex = count($item) - 1;
            $string = $item[count($item) - 1];
            $groupKey = '';
    
            for ($i = 0; $i <= mb_strlen($string) - 10; $i++) {
                $substring = mb_substr($string, $i, 10);
    
                $isSubstringInOtherItems = $collection->filter(function ($otherItem) use ($substring,$enditemindex) {
                    $otherString = $otherItem[count($otherItem) - 1];               
                    return mb_strpos($otherString, $substring) !== false;
                })->isNotEmpty();
    
                if ($isSubstringInOtherItems) {
                    $groupKey = $substring;
                    break;
                }
            }
    
            return $groupKey;
        };
    
        // グループ化されたコレクションを作成
        $groupedCollection = $collection->groupBy($groupKeyCallback);
    
        // グループ名の行でソート
        $groupedCollection = $groupedCollection->sort(function ($a, $b) {
            if ($a->isEmpty() && $b->isEmpty()) {
                return 0;
            } elseif ($a->isEmpty()) {
                return 1;
            } elseif ($b->isEmpty()) {
                return -1;
            }
    
            $groupA = $a->first()[2] ?? '';
            $groupB = $b->first()[2] ?? '';
    
            return strcmp($groupA, $groupB);
        });
    
        // グループ化されたデータを出力
        $csvData = '';
        foreach ($groupedCollection as $group => $items) {
            $csvData .= "Group: $group\n"; // グループ名の行
            $csvData .= "ID,Name,Group\n"; // ヘッダー行
    
            foreach ($items as $item) {
                $csvData .= implode(',', $item) . "\n"; // データ行
            }
    
            $csvData .= "\n\n"; // 改行
        }
    
        // 一時ファイルの削除
        Storage::delete($filePath);

        // ファイルの保存
        $timestamp = Carbon::now()->format('YmdHisu');
        $fileName = 'r_'.$timestamp.'.csv';
        Storage::put('amecan/'.$fileName, $csvData);

        // ファイルのパスを返却
        $filePath = storage_path('app/amecan/' . $fileName);
        
        return view('dev/home', compact("filePath"));
    }
}
