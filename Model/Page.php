<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagentoEse\VeniaCmsSampleData\Model;

use Magento\Framework\Setup\SampleData\Context as SampleDataContext;
use Magento\Store\Model\Store;

class Page
{
    /**
     * @var \Magento\Framework\Setup\SampleData\FixtureManager
     */
    private $fixtureManager;

    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvReader;

    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $pageFactory;

    /**
     * 
     * @var array
     */
    protected $config;

    /**
     * 
     * @var Store
     */
    protected $storeView;

    /**
     * 
     * @param SampleDataContext $sampleDataContext 
     * @param Magento\Cms\Model\PageFactory $pageFactory 
     * @param Store $storeView 
     * @return void 
     */
    public function __construct(
        SampleDataContext $sampleDataContext,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Store\Model\Store $storeView

    ) {
        $this->fixtureManager = $sampleDataContext->getFixtureManager();
        $this->csvReader = $sampleDataContext->getCsvReader();
        $this->pageFactory = $pageFactory;
        $this->config = require 'Config.php';
        $this->storeView = $storeView;
    }

    /**
     * @param array $fixtures
     * @throws \Exception
     */
    public function install(array $fixtures)
    {
        //get view id from view code
        $_viewId = $this->storeView->load($this->config['viewCode'])->getStoreId();

        foreach ($fixtures as $fileName) {
            $fileName = $this->fixtureManager->getFixture($fileName);
            if (!file_exists($fileName)) {
                continue;
            }

            $rows = $this->csvReader->getData($fileName);
            $header = array_shift($rows);

            foreach ($rows as $row) {
                $data = [];
                foreach ($row as $key => $value) {
                    $data[$header[$key]] = $value;
                }
                $row = $data;

                $this->pageFactory->create()
                    ->addData($row)
                    ->setStoreId($_viewId)
                    ->save();
            }
        }
    }
}
