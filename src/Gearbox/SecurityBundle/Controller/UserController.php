<?php


namespace Gearbox\SecurityBundle\Controller;

use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use Gearbox\ApiBundle\Controller\ApiController;
use Gearbox\ApiBundle\Exception\InvalidFormException;
use Gearbox\SecurityBundle\Entity\User;
use Gearbox\SecurityBundle\Model\UserManager;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends ApiController
{
    /**
     * @var UserManager
     */
    private $service;

    /**
     *
     */
    public function init()
    {
        $this->service = $this->container->get('gearbox_security.user.manager');
    }

    /**
     * Get users
     *
     * @ApiDoc(
     *      section="Users",
     *      resource = true,
     *      statusCodes = {
     *          200 = "Returned when successful"
     *      }
     * )
     *
     * @param Request $request The request object
     *
     * @return array
     */
    public function cgetAction(Request $request)
    {
        return array('users' => $this->service->findBy(array()));
    }

    /**
     * Get user
     *
     * @ApiDoc(
     *      section="Users",
     *      resource = true,
     *      statusCodes = {
     *          200 = "Returned when successful",
     *          404 = "Returned when the user is not found"
     *      }
     * )
     *
     * @param string $userName The username of the user
     *
     * @return array
     */
    public function getAction($userName)
    {
        return array('user' => $this->getOr404($userName));
    }

    /**
     * Create user
     *
     * @ApiDoc(
     *      section="Users",
     *      resource = true,
     *      input = "Gearbox\SecurityBundle\Form\UserType",
     *      statusCodes = {
     *          201 = "Returned when created",
     *          400 = "Returned when validation errors occurred"
     *      }
     * )
     *
     * @param Request $request The request object
     *
     * @return FormTypeInterface|View
     */
    public function postAction(Request $request)
    {
        try {
            $newUser = $this->service->create($request->request->all());

            $routeOptions = array(
                'id'      => $newUser->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_get_user', $routeOptions, Codes::HTTP_CREATED);
        } catch (InvalidFormException $e) {
            return $e->getForm();
        }
    }

    /**
     * Update user
     *
     * @ApiDoc(
     *      section="Users",
     *      resource = true,
     *      statusCodes = {
     *          204 = "Returned when successful",
     *          400 = "Returned when validation errors occurred",
     *          404 = "Returned when the user is not found"
     *      }
     * )
     *
     * @param string $userName The username of the user
     * @param Request $request The request object
     *
     * @return FormTypeInterface|View
     */
    public function putAction($userName, Request $request)
    {
        try {
            $user = $this->service->update(
                $this->getOr404($userName),
                $request->request->all()
            );

            $routeOptions = array(
                'id'      => $user->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_get_user', $routeOptions, Codes::HTTP_NO_CONTENT);
        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Delete user
     *
     * @ApiDoc(
     *      section="Users",
     *      resource = true,
     *      statusCodes = {
     *          204 = "Returned when deleted",
     *          404 = "Returned when the user is not found"
     *      }
     * )
     *
     * @param int $userName The username of the user
     *
     * @return FormTypeInterface|View
     */
    public function deleteAction($userName)
    {
        $this->service->delete(
            $this->getOr404($userName)
        );

        return View::create(null, Codes::HTTP_NO_CONTENT);
    }

    /**
     * Get user
     *
     * @param string $userName
     *
     * @return User
     * @throws NotFoundHttpException
     */
    private function getOr404($userName)
    {
        $user = $this->service->get($userName);
        if (!$user instanceof User) {
            throw new NotFoundHttpException(sprintf('User "%s" not found', $userName));
        }

        return $user;
    }
}