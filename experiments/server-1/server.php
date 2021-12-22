<?php
// turn off WSDL caching
ini_set("soap.wsdl_cache_enabled","0");
// model, which uses in web service functions as parameter
class Book
{
        public $name;
        public $year;
}

/**
 * Determines published year of the book by name.
 * @param Book $book book instance with name set.
 * @return int published year of the book or 0 if not found.
 */
function bookYear($book)
{
        // list of the books
        $_books=[
                ['name'=>'test 1','year'=>2011],
                ['name'=>'test 2','year'=>2012],
                ['name'=>'test 3','year'=>2013],
        ];
        // search book by name
        foreach($_books as $bk)
                if($bk['name']==$book->name)
                        return $bk['year']; // book found

        return 0; // book not found
}

// initialize SOAP Server
$server=new SoapServer("test.wsdl",[
        'classmap'=>[
                'book'=>'Book', // 'book' complex type in WSDL file mapped to the Book PHP class
        ]
]);

// register available functions
$server->addFunction('bookYear');

while(1){
// start handling requests
        $server->handle();
};
