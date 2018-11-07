<?php

namespace MagentoEse\VeniaCmsSampleData\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Config\ConfigOptionsListConstants;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * UpgradeData constructor.
     * @param \Magento\Framework\App\ResourceConnection $resource
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->resource = $resource;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.0.3') < 0) {
            // Homepage CMS Page
            $this->updateCmsPageContent('Home Page - Venia', file_get_contents('MagentoEse_VeniaCmsSampleData::fixtures/venia-home-pb.txt'));

            // CLP Tops Block CMS
            $this->updateCmsBlockContent('venia-clp-tops', file_get_contents('MagentoEse_VeniaCmsSampleData::fixtures/venia-clp-tops-pb.txt'));
        }

        $setup->endSetup();
    }

    /**
     * Update the CMS pages content
     *
     * @param $title
     * @param $content
     */
    public function updateCmsPageContent($title, $content)
    {
        $this->resource->getConnection()->update('cms_page', ['content' => $content], ['title = ?' => $title]);
    }

    /**
     * Update a CMS blocks content
     *
     * @param $identifier
     * @param $content
     */
    public function updateCmsBlockContent($identifier, $content)
    {
        $this->resource->getConnection()->update('cms_block', ['content' => $content], ['identifier = ?' => $identifier]);
    }

}
