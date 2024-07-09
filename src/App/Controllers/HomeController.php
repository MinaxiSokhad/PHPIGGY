<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
//use App\Config\Paths;
use App\Services\TransactionService;

class HomeController //create a controller
{
    //private TemplateEngine $view;
    public function __construct(
    private TemplateEngine $view,
    private TransactionService $transactionService
    )
    {
        //var_dump($this->view); // for singleton pattern
        // echo '<br>';
        // $this->view = new TemplateEngine(Paths::VIEW); //instance of template engine

    }
    public function home()
    {
        $page = $_GET['p'] ?? 1;
        $page = (int) $page;
        $length = 3; //show 3 result per page
        $offset = ($page - 1) * $length;
        $searchTerm = $_GET['s'] ?? null;
        [$transactions,$count] = $this->transactionService->getUserTransactions(
            $length,
            $offset
        );
        //dd($this->view); //using sugar function pass the instance of template engine
        // echo "Home page ";
        // $secret = "sdsdagasag";

        // return
        $lastPage = ceil($count/$length);
        $pages = $lastPage ? range(1,$lastPage) : [];
        $pageLink = array_map(
            fn($pageNum) => http_build_query([
                'p' => $pageNum,
                's' => $searchTerm
            ]),
            $pages
        );
        echo $this->view->render("/index.php", [
            // 'title' => 'Home pagee'
            'transactions'=> $transactions,
            'currentPage' => $page,
            'previousPageQuery' => http_build_query([
                'p'=> $page - 1,
                's'=> $searchTerm
                 ]
            ),
            'lastPage' => $lastPage,
            'nextPageQuery' => http_build_query(
                ['p' => $page + 1,
                's' => $searchTerm]
            ),
            'pageLink' => $pageLink,
            'searchTerm' => $searchTerm
        ]);
    }
}
