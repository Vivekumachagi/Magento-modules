<?php
namespace Grc\GuestUser\Controller\Index;

use Magento\Framework\App\Action\Context;
use Grc\GuestUser\Model\GuestUserFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Response\Http\FileFactory;
use u2flib_server\Error;

class SaveGuestUser extends \Magento\Framework\App\Action\Action
{
    /**
     * @var GuestUserFactory
     */
    protected $_guestuser;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_filesystem;
    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;


    public function __construct(
        GuestUserFactory       $guestuser,
        Filesystem             $filesystem,
        FileFactory            $fileFactory,
        Context                $context
    )
    {
        $this->_guestuser = $guestuser;
        $this->_filesystem = $filesystem;
        $this->fileFactory = $fileFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getParams();
        if ($data){
            $guestUserData = $this->_guestuser->create();
            $guestUserData->setData($data);
            $guestUserData->save();
        }
        $mediapath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        $fileName = $this->getRequest()->getParam('filename');
        $filePath = $mediapath . 'catalog/product/file/' . $fileName;
        $downloadName = $fileName;
        $content['type'] = 'filename';
        $content['value'] = $filePath;
        $content['rm'] = 0;
        if($fileName){
            try {
                return $this->fileFactory->create($downloadName, $content, DirectoryList::PUB);
            }
            catch (Exception $e) {
                $this->messageManager->addErrorMessage(__('An error occurred while downloading the file. Please try again later.'));
            }
        }
        else{
            $this->messageManager->addErrorMessage(__('There is no sample file found for this product.'));
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }
    }

}

