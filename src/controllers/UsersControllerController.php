<?php
/**
 * tuersteher plugin for Craft CMS 3.x
 *
 * Craft CMS Plugin to restrict the view of the Frontend only to registered users
 *
 * @link      http://raz.ddnss.de
 * @copyright Copyright (c) 2018 Rainer Zarth
 */

namespace rainerzarth\tuersteher\controllers;

use rainerzarth\tuersteher\Tuersteher;

use Craft;
use craft\web\Controller;

/**
 * UsersController Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Rainer Zarth
 * @package   Tuersteher
 * @since     1.0.0
 */
class UsersControllerController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'login'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/tuersteher/users-controller
     *
     * @return mixed
     */

    public function actionIndex()
    {
        if (Tuersteher::$plugin->hasPermission()) {
            return $this->redirect('/');
        }
        
        return $this->renderFrontendTemplate('login');
    }

    /**
     * Handle a request going to our plugin's actionDoSomething URL,
     * e.g.: actions/tuersteher/users-controller/do-something
     *
     * @return mixed
     */

    private function renderFrontendTemplate(string $template, array $params = []): string
    {
        $oldMode = $this->view->getTemplateMode();
        $this->view->setTemplateMode(View::TEMPLATE_MODE_CP);

        $rendered = $this->view->renderTemplate($template, $params);
        
        $this->view->setTemplateMode($oldMode);

        return $rendered;
    }
}
