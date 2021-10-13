<?php

class Catalogue{

    //pendeskripsian /memasukkan setiap kolom  dan baris yang ada di txt ke dalam array
    function createProductColumn($columns, $listOfRawProduct){
        
        foreach (array_keys($listOfRawProduct) as $listOfRawProductKey)
        {
            $listOfRawProduct[$columns[$listOfRawProductKey]] = $listOfRawProduct[$listOfRawProductKey];//pendeklarasian array yang ada untuk dimasukki oleh nilai pada txt
            unset($listOfRawProduct[$listOfRawProductKey]);
        }
        return $listOfRawProduct;
    }



    //pembuatan fungsi produk untuk membaca isian file lalu dimasukkan ke dalam array
    function product($parameters){
        $collectionOfListProduct = []; //pendeskripsian array baru

        $raw_data = file($parameters['file_name']);//pendefinisan variabel penampung dari file yang ada di txt

        //pengisian collectionoflist product
        foreach ($raw_data as $listOfRawProduct){
            $collectionOfListProduct[] = $this->createProductColumn($parameters['columns'], 
                explode(",",$listOfRawProduct));
        }


        return [
            'product' => $collectionOfListProduct,
            'gen_length' => count($collectionOfListProduct)
        ];//pengembalian berbentuk array [0,1] dengan inisialisasi [roduct, gen_length]
    }
}

//digunakan untuk membuat populasi tergantung dengan jumlah populasi yang ada di $parameter
class PopulationGenerator{

    function createIndividu($parameters){
        $catalogue = new Catalogue;

        //inisialisasi lengthGen dengan inisialisasi pemanggilan dari fungsi produk di class catalog dengan parameter gen_length
        $lengthOfGen = $catalogue->product($parameters)['gen_length'];
        
        //perulangan yang mengisikan variabel  ret[] dengan isian random 0 dan 1
        for($i = 0; $i <= $lengthOfGen-1; $i++){
            $ret[]= rand(0,1);
        }
        return $ret;
        //pengembalian variabel ret
    }
    
    //pembuatan populasi
    function createPopulation($parameters){
        
        //perulangan unutk mengisi variabel ret(individu) dengan pemanggilan createindividu 
        for ($i = 0; $i <= $parameters['population_size']; $i++){
            $ret[] = $this->createIndividu($parameters);
        }
        
        //penampilan $ret yang sudah di isikan ke dalam $key lalu dimasukkan lagi ke dalam val dan di print r
        foreach ($ret as $key => $val){
            // print "<pre>";
            print_r($val);
            echo '<br>';
            // print "<pre>";
        }
    }

}


$parameters = [
    'file_name' => 'products.txt',
    'columns' => ['item','price'],
    'population_size' => 10
];

$katalog = new Catalogue;

// print "<pre>";
// print_r($katalog->product($parameters));
// print "<pre>";

$initialPopulation = new PopulationGenerator;
$initialPopulation->createPopulation($parameters);