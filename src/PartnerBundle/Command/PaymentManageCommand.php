<?php

namespace PartnerBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use PartnerBundle\Entity\Partner;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PaymentManageCommand extends ContainerAwareCommand
{
    const CONTRACT_INDEX = 0;
    const STATUS_INDEX = 1;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var string */
    protected $inputPath;

    /**
     * PaymentManageCommand constructor.
     * @param EntityManagerInterface $em
     * @param null $name
     */
    public function __construct(EntityManagerInterface $em, $name = null)
    {
        $this->em = $em;
        parent::__construct($name);
    }

    /** @inheritDoc */
    protected function configure()
    {
        $this
            ->setName('partner:payment:manage')
            ->setDescription('Enable / Disable payment for Partner by providing config file')
            ->setHelp('This command manage payment status for partners.')
            ->addArgument('input', InputArgument::REQUIRED, 'Input file of config XLS/XLSX.')
            ->addOption('header', 'H', InputOption::VALUE_NONE, 'If file has header row.')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputPath = $input->getArgument('input');
        $thereHasHeader = $input->getOption('header');

        $spreadsheet = IOFactory::load($inputPath);
        $worksheet = $spreadsheet->getActiveSheet();

        $rows = $worksheet->toArray();
        $total = count($rows);

        $total -= $thereHasHeader ? 1 : 0;

        $io = new SymfonyStyle($input, $output);
        $io->title(sprintf('Manage payment status for %s partners', $total));

        $partnerRepository = $this->em->getRepository(Partner::class);

        foreach ($rows as $key => $row) {
            if (0 === $key && $thereHasHeader || empty($row[self::CONTRACT_INDEX])) {
                continue;
            }

            if (null === $row[self::CONTRACT_INDEX] || null === $row[self::STATUS_INDEX] || !is_bool((bool) $row[self::STATUS_INDEX])) {
                $io->error(sprintf(
                    'Invalid data in line #%s', $key + 1
                ));

                continue;
            }

            $contractNumber = $row[self::CONTRACT_INDEX];
            $onlineQuotation = (bool) $row[self::STATUS_INDEX];
            /** @var Partner $partner */
            $partner = $partnerRepository->findOneBy(['contractNumber' => $contractNumber]);

            if ($partner && $onlineQuotation !== $partner->isOnlineQuotation()) {
                $partner->setOnlineQuotation($onlineQuotation);
            }
        }

        $this->em->flush();

        $io->success('End');
    }

}