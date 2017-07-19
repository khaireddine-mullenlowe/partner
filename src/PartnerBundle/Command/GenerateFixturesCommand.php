<?php

namespace PartnerBundle\Command;

use PartnerBundle\Entity\Partner;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class GenerateFixturesCommand
 * Extract partners
 * @package PartnerBundle\Command
 */
class GenerateFixturesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('partner:fixtures:generate')
            ->setDescription('Extract partners')
            ->addOption('output', 'o', InputOption::VALUE_OPTIONAL, 'output yaml file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fixtures = ['partners' => $this->generatePartners()];
        $outputYml = Yaml::dump($fixtures, 2, 4, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
        if ($input->getOption('output')) {
            return file_put_contents($input->getOption('output'), $outputYml);
        }

        return $output->writeln([$outputYml]);
    }

    protected function generatePartners()
    {
        $fixtures = [];
        $repository = $this->getContainer()->get("doctrine")->getRepository('PartnerBundle:Partner');
        $partners = $repository->findAll();

        foreach ($partners as $partner) {
            /**
             * @var Partner $partner
             */

            $registryUserList = [];
            foreach ($partner->getRegistryUsers() as $registryUser) {
                $registryUserList[] = $registryUser->getRegistryUserId();
            }
            $fixtures[] = [
                'registry_users' => $registryUserList,
                'contract_number' => $partner->getContractNumber(),
                'commercial_name'  => $partner->getCommercialName(),
                'kvps_number' => $partner->getKvpsNumber(),
                'web_site' => $partner->getWebSite(),
                'myaudi_users' => [],
                'addresses' => [],
                'partner_id' => $partner->getPartnerId(),
                'type' => $partner->getType(),
                'is_etron' => $partner->isEtron(),
                'is_occ_plus' => $partner->isOccPlus(),
                'is_partner_plus' => $partner->isPartnerPlus(),
                'is_partner_r8' => $partner->isPartnerR8(),
                'is_twin_service' => $partner->isTwinService(),
            ];
        }

        return $fixtures;
    }
}
