<?php
/**
 * Copyright © 2015 iCube. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Icube\UpgradeScript\Setup;

use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Page factory
     *
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var BlockFactory
     */
    protected $blockFactory;

    /**
     * Init
     *
     * @param PageFactory $pageFactory
     */
    public function __construct(
        BlockFactory $modelBlockFactory,
        PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        $this->blockFactory = $modelBlockFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * cms page sample
         */
        $pageContent = <<<EOD
test
EOD;

        $cmsPage = [
            'title' => 'test',
            'content_heading' => 'test',
            'page_layout' => '1column',
            'identifier' => 'test-cms-page',
            'content' => $pageContent,
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0,
        ];

        $this->createPage()->setData($cmsPage)->save();


        /**
         * cms block sample
         */
        $cmsBlock = [
            'title' => 'test cms block',
            'identifier' => 'test_cms_block',
            'content' => 'cms block sample',
            'is_active' => 1,
            'stores' => 0,
        ];

        /** @var \Magento\Cms\Model\Block $block */
        $block = $this->blockFactory->create();
        $block->setData($cmsBlock)->save();

    }

    /**
     * Create page
     *
     * @return Page
     */
    public function createPage()
    {
        return $this->pageFactory->create();
    }
}
