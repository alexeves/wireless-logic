<?php

declare(strict_types=1);

namespace WirelessLogic\Tests\PHPUnit\Integration\Products;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use WirelessLogic\Application\Application;
use WirelessLogic\Domain\Products\Product;
use WirelessLogic\Symfony\Console\ListProductsCommand;

class ListProductsCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_fetch_and_return_a_collection_of_products_in_json_format(): void
    {
        $application = $this->createMock(Application::class);
        $application
            ->expects($this->once())
            ->method('listProducts')
            ->willReturn(new ArrayCollection([
                Product::monthlySubscription('monthly', 'description', 1000),
                Product::annualSubscription('annually', 'description', 999, 1),
            ]))
        ;

        $command = new ListProductsCommand($application);

        $symfonyApplication = new SymfonyApplication();
        $symfonyApplication->add($command);
        $sut = $symfonyApplication->find(ListProductsCommand::getDefaultName());
        $commandTester = new CommandTester($sut);
        $result = $commandTester->execute([]);

        $this->assertEquals(Command::SUCCESS, $result);
        $this->assertEquals('[{"title":"monthly","description":"description","annualPrice":12000,"discount":0,"subscriptionType":"Monthly"},{"title":"annually","description":"description","annualPrice":999,"discount":1,"subscriptionType":"Annual"}]', trim($commandTester->getDisplay()));
    }
}
