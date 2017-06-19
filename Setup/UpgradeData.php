<?php

namespace MagentoEse\VeniaCmsSampleData\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Config\ConfigOptionsListConstants;

class UpgradeData implements UpgradeDataInterface
{
      public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
      {
          $setup->startSetup();
          if (version_compare($context->getVersion(), '0.0.2') < 0
          ) {

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();
            $tableName = $resource->getTableName('gene_bluefoot_stage_template');
            $tableNamePage = $resource->getTableName('cms_page');
            $tableNameBlock = $resource->getTableName('cms_block');
            $config = $objectManager->get('Magento\Framework\App\DeploymentConfig');
            $dbName = $config->get(ConfigOptionsListConstants::CONFIG_PATH_DB_CONNECTION_DEFAULT. '/' . ConfigOptionsListConstants::KEY_NAME);
            $dbUser = $config->get(ConfigOptionsListConstants::CONFIG_PATH_DB_CONNECTION_DEFAULT. '/' . ConfigOptionsListConstants::KEY_USER);
            $dbPass = $config->get(ConfigOptionsListConstants::CONFIG_PATH_DB_CONNECTION_DEFAULT. '/' . ConfigOptionsListConstants::KEY_PASSWORD);
            $dbHost = $config->get(ConfigOptionsListConstants::CONFIG_PATH_DB_CONNECTION_DEFAULT. '/' . ConfigOptionsListConstants::KEY_HOST);
            $mysqliConnection = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);
            $bluefootVeniaHome = mysqli_real_escape_string ($mysqliConnection,json_encode(json_decode(file_get_contents(__DIR__.'/venia-home.json'),true)));

            // INSERT DATA
            $sql = "INSERT INTO `gene_bluefoot_stage_template` (`template_id`, `name`, `structure`, `has_data`, `preview`, `pinned`, `created_at`, `updated_at`)
            VALUES
              (1, 'Venia Home', '$bluefootVeniaHome', 1, '".file_get_contents(__DIR__.'/venia-home.png.txt')."', 0, '2017-03-29 18:54:14', '2017-04-02 12:00:00');";
            $connection->query($sql);

            $bluefootVeniaClpTops = mysqli_real_escape_string ($mysqliConnection,json_encode(json_decode(file_get_contents(__DIR__.'/venia-clp-tops.json'),true)));

            $sql = "INSERT INTO `gene_bluefoot_stage_template` (`template_id`, `name`, `structure`, `has_data`, `preview`, `pinned`, `created_at`, `updated_at`)
            VALUES
            (2, 'Venia CLP Tops', '$bluefootVeniaClpTops', 1, '".file_get_contents(__DIR__.'/venia-clp-tops.png.txt')."', 0, '2017-03-29 18:54:43', '2017-04-02 12:00:00');";
            $connection->query($sql);


            // Homepage CMS Page

            $bluefootVeniaHomeContent = mysqli_real_escape_string ($mysqliConnection, '<!--GENE_BLUEFOOT="'.json_encode(json_decode(file_get_contents(__DIR__.'/venia-home-content.json'),true)).'"-->');

            $pageName = '"Home Page - Venia"';
            $sql = "UPDATE " . $tableNamePage . " SET content = '$bluefootVeniaHomeContent' WHERE title LIKE " . $pageName;
            $connection->query($sql);

            // CLP Tops Block CMS
            $bluefootVeniaClpTopsContent = mysqli_real_escape_string($mysqliConnection,'<!--GENE_BLUEFOOT="'.json_encode(json_decode(file_get_contents(__DIR__.'/venia-clp-tops-content.json'),true)).'"-->');
            $blockIdentifier = '"venia-clp-tops"';
            $sql = "UPDATE " . $tableNameBlock . " SET content = '$bluefootVeniaClpTopsContent' WHERE identifier = " . $blockIdentifier;
            $connection->query($sql);

          }

          $setup->endSetup();

        }
}
