<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\User;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

final class Version20191212025637 extends AbstractMigration implements ContainerAwareInterface {

    use ContainerAwareTrait;

    public function getDescription()
    : string {
        return 'Fill table user with some test users';
    }

    /**
     * @param Schema $schema
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function up(Schema $schema)
    : void {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');

        $user1 = (new User())
            ->setName('Jablotron')
            ->setEmail('info@jablotron.cz')
            ->setAccessToken('93f39e2f-80de-4033-99ee-249d92736a25');

        $user2 = (new User())
            ->setName('Batman')
            ->setEmail('batman@example.com')
            ->setAccessToken('dcb20f8a-5657-4f1b-9f7f-ce65739b359e');

        $em->persist($user1);
        $em->persist($user2);

        $em->flush();
    }

    /**
     * @param Schema $schema
     * @throws DBALException
     */
    public function down(Schema $schema)
    : void {
        $this->connection->executeQuery('TRUNCATE TABLE user');
    }

}
