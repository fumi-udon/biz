<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Collection;

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
}
