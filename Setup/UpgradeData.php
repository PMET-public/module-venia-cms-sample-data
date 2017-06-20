<?php

namespace MagentoEse\VeniaCmsSampleData\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Config\ConfigOptionsListConstants;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var \Gene\BlueFoot\Model\Stage\SaveFactory
     */
    protected $saveFactory;

    /**
     * @var
     */
    protected $connection;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * UpgradeData constructor.
     * @param \Gene\BlueFoot\Model\Stage\SaveFactory $saveFactory
     * @param \Magento\Framework\App\ResourceConnection $resource
     */
    public function __construct(
        \Gene\BlueFoot\Model\Stage\SaveFactory $saveFactory,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->saveFactory = $saveFactory;
        $this->resource = $resource;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.0.2') < 0) {
            // Homepage CMS Page
            $this->updateCmsPageContent('Home Page - Venia', $this->buildStructureFromTemplate(__DIR__ . '/venia-home-content.json'));

            // CLP Tops Block CMS
            $this->updateCmsBlockContent('venia-clp-tops', $this->buildStructureFromTemplate(__DIR__ . '/venia-clp-tops-content.json'));
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

    /**
     * Build the structure from a template housed within an external JSON file
     *
     * @param $templateLocation
     * @return string
     */
    public function buildStructureFromTemplate($templateLocation)
    {
        return $this->buildStructureFromTemplateString(file_get_contents($templateLocation));
    }

    /**
     * Build the final structure from the template string
     *
     * @param $templateJson
     * @return string
     * @throws \Exception
     */
    public function buildStructureFromTemplateString($templateJson)
    {
        $saveFactory = $this->saveFactory->create();
        if ($decodedStructure = $saveFactory->decodeStructure($templateJson)) {
            $saveFactory->createStructure($decodedStructure);
            return $saveFactory->encodeStructure($decodedStructure);
        } else {
            throw new \Exception('Unable to convert template data into fully formed BlueFoot structure.');
        }
    }
}
