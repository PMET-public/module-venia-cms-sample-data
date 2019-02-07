<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MagentoEse\VeniaCmsSampleData\Setup\Patch\Data;


use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;


class OldUpgradeData implements DataPatchInterface,PatchVersionInterface
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

    public function apply()
    {
        // Homepage CMS Page
        $this->updateCmsPageContent('Home Page - Venia', file_get_contents(__DIR__ . '/../../../fixtures/venia-home-pb.txt'));
        $this->updateCmsPageLayout('Home Page - Venia', 'cms-full-width');

        // CLP Tops Block CMS
        $this->updateCmsBlockContent('venia-clp-tops', file_get_contents(__DIR__ . '/../../../fixtures/venia-clp-tops-pb.txt'));
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
     * Update the CMS pages layout
     *
     * @param $title
     * @param $layout
     */
    public function updateCmsPageLayout($title, $layout)
    {
        $this->resource->getConnection()->update('cms_page', ['page_layout' => $layout], ['title = ?' => $title]);
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

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
    public static function getVersion()
    {
        return '0.0.3';
    }
}