<?php

namespace App\Controller;

use App\WebClients\Bitcoin\IBitcoinWebClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BitcoinController extends AbstractController
{
    protected IBitcoinWebClient $bitcoinWebClient;

    public function __construct(IBitcoinWebClient $bitcoinWebClient)
    {
        $this->bitcoinWebClient = $bitcoinWebClient;
    }

    #[Route('/bitcoin', name: 'app_bitcoin')]
    public function index(): Response
    {
        return $this->render('bitcoin/index.html.twig', [
            'controller_name' => 'BitcoinController',
            'bitcoinPrice' => $this->bitcoinWebClient->recupererPrixBitcoin(),
            'ethereumPrice' => $this->bitcoinWebClient->functionRecupererPrixCrypto('ethereum'),
            'auteur' => 'Siwa'
        ]);
    }
}
