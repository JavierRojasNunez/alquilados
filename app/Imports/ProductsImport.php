<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\ToModel;


class ProductsImport implements ToModel, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    */
    public function model(array $row)
    {
        
            if($row[0] != 'PRODUCT'){

                
                return new Product([
                    'reference' => $row[0],
                    'category' => $row[1],
                    'cost'      => $row[2],
                    'quantity'  => $row[3],
                ]);

            }
                    
        
    }

    public function batchSize(): int
    {
        return 10000;
    }

    public function chunkSize(): int
    {
        return 10000;
    }
}
