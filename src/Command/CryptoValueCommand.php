<?php

namespace App\Command;

use App\WebClients\Bitcoin\IBitcoinWebClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'CryptoValueCommand',
    description: 'Add a short description for your command',
    aliases: ['app:crypto'],
)]
class CryptoValueCommand extends Command
{
    protected IBitcoinWebClient $bitcoinWebClient;

    public function __construct(IBitcoinWebClient $bitcoinWebClient)
    {
        $this->bitcoinWebClient = $bitcoinWebClient;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        $crypto = null;
        $helper = $this->getHelper('question');

        if ($arg1) {
            $crypto = $arg1;
        }
        else
        {
            $question = new Question("Veuillez saisir le nom du crypto : \n");
            $crypto = $helper->ask($input, $output, $question);
        }

        try {
            $prixCrypto = $this->bitcoinWebClient->functionRecupererPrixCrypto($crypto);
            $io->success("La valeur du $crypto est de : ".$prixCrypto);
        } catch (\Exception $e) {
            $io->error('Erreur lors de la récupération de la valeur du crypto');
        }

        return Command::SUCCESS;
    }
}
