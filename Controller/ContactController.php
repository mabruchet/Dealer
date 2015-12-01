<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/
/*************************************************************************************/

namespace Dealer\Controller;

use Dealer\Controller\Base\BaseController;
use Dealer\Dealer;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Tools\URL;

/**
 * Class ContactController
 * @package Dealer\Controller
 */
class ContactController extends BaseController
{
    const CONTROLLER_ENTITY_NAME = "dealer-contact";

    /**
     * Use to get render of list
     * @return mixed
     */
    protected function getListRenderTemplate()
    {
        $id = $this->getRequest()->query->get("dealer_id");

        return new RedirectResponse(URL::getInstance()->absoluteUrl("/admin/module/Dealer/dealer/edit",
            ["dealer_id" => $id,]));
    }

    /**
     * Must return a RedirectResponse instance
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirectToListTemplate()
    {
        $id = $this->getRequest()->request->get("dealer_id");

        return new RedirectResponse(URL::getInstance()->absoluteUrl("/admin/module/Dealer/dealer/edit",
            ["dealer_id" => $id,]));
    }

    /**
     * Use to get Edit render
     * @return mixed
     */
    protected function getEditRenderTemplate()
    {
        return $this->render("dealer-edit");
    }

    /**
     * Use to get Create render
     * @return mixed
     */
    protected function getCreateRenderTemplate()
    {
        return $this->render("dealer-edit");
    }

    /**
     * @return mixed
     */
    protected function getObjectId($object)
    {
        $object->getId();
    }

    /**
     * Load an existing object from the database
     */
    protected function getExistingObject()
    {
        // TODO: Implement getExistingObject() method.
    }

    /**
     * Hydrate the update form for this object, before passing it to the update template
     *
     * @param mixed $object
     */
    protected function hydrateObjectForm($object)
    {
        // TODO: Implement hydrateObjectForm() method.
    }

    /**
     * Method to get current controller associated service
     * @return object
     */
    protected function getService()
    {
        if (!$this->service) {
            $this->service = $this->getContainer()->get("dealer_contact_service");
        }

        return $this->service;
    }

    public function toggleDefaultAction()
    {
        // Check current user authorization
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, Dealer::getModuleCode(),
                AccessManager::UPDATE)
        ) {
            return $response;
        }
        try {
            $request = $this->getRequest()->request;

            $data = [
                'id' => $request->get("dealer_contact_id"),
                'is_default' => $request->get("is_default")
            ];


            $this->getService()->setDefault($data);
            if ($response == null) {
                return $this->redirectToListTemplate();
            } else {
                return $response;
            }
        } catch (\Exception $e) {
            return $this->renderAfterDeleteError($e);
        }
    }


}