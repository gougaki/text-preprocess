<?php

    class stemming{
        function stemm($teks){    
            require_once __DIR__ . '/vendor/autoload.php';

            $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
            $stemmer  = $stemmerFactory->createStemmer();
            $output   = $stemmer->stem($teks);
            return $output;
        }
    }
?>