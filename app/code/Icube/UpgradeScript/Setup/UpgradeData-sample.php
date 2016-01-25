<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Icube\UpgradeScript\Setup;

use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
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
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            /**
             * update cms page sample
             */
            $pageContent = <<<EOD
test update
EOD;

            $cmsPage = $this->createPage()->load('test-cms-page', 'identifier');

            if (!$cmsPage->getId()) {
                $cmsPageContent = [
                    'title' => 'test update',
                    'content_heading' => 'test',
                    'page_layout' => '1column',
                    'identifier' => 'test-cms-page',
                    'content' => $pageContent,
                    'is_active' => 1,
                    'stores' => [0],
                    'sort_order' => 0,
                ];
                $this->createPage()->setData($cmsPageContent)->save();
            } else {
                $cmsPage->setContent($pageContent)->save();
            }


            /**
             * update cms block sample
             */

            $cmsBlockContent = <<<EOD
cms block sample update
EOD;
            $cmsBlock = $this->createBlock()->load('test_cms_block', 'identifier');

            if (!$cmsPage->getId()) {

                $cmsBlock = [
                    'title' => 'test cms block update',
                    'identifier' => 'test_cms_block',
                    'content' => $cmsBlockContent,
                    'is_active' => 1,
                    'stores' => 0,
                ];
                $this->createBlock()->setData($cmsBlock)->save();
            } else {
                $cmsBlock->setContent($cmsBlockContent)->save();
            }




        }

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

    /**
     * Create block
     *
     * @return Page
     */
    public function createBlock()
    {
        return $this->blockFactory->create();
    }
}
