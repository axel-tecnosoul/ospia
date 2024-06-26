<?php
/*
 * This file is part of the ManageWP Worker plugin.
 *
 * (c) ManageWP LLC <contact@managewp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class MWP_EventListener_PublicRequest_SetPluginInfo implements Symfony_EventDispatcher_EventSubscriberInterface
{

    private $context;

    private $brand;

    private $slug = 'worker/init.php';

    private $loaderName = '0-worker.php';

    function __construct(MWP_WordPress_Context $context, MWP_Worker_Brand $brand)
    {
        $this->context = $context;
        $this->brand   = $brand;
    }

    public static function getSubscribedEvents()
    {
        return array(
            MWP_Event_Events::PUBLIC_REQUEST => 'onPublicRequest',
        );
    }

    public function onPublicRequest()
    {
        $this->context->addFilter('all_plugins', array($this, 'pluginInfoFilter'));
        $this->context->addFilter('all_plugins', array($this, 'pluginListFilter'));
        // This hook will re-brand plugin and MU plugin in WP 5.2 site health page.
        $this->context->addFilter('debug_information', array($this, 'pluginGetHealthInfoFilter'));
        // This is a horrible hack, but it will allow us to hide a MU plugin in rebranded installations.
        $this->context->addFilter('show_advanced_plugins', array($this, 'muPluginListFilter'), 10, 2);
        $this->context->addFilter('plugin_row_meta', array($this, 'hidePluginDetails'), 10, 2);
        $this->context->addFilter('site_transient_update_plugins', array($this, 'parseUpdatePlugins'));
    }

    public function parseUpdatePlugins($updates)
    {
        if (!$this->brand->isActive()) {
            return $updates;
        }

        if (isset($updates->response[$this->slug])) {
            unset($updates->response[$this->slug]);
        }

        return $updates;
    }

    /**
     * @wp_filter all_plugins
     */
    public function pluginInfoFilter($plugins)
    {
        if (!isset($plugins[$this->slug])) {
            return $plugins;
        }

        if ($this->context->optionGet('mwp_pro_connected') == true) {
            $plugins[$this->slug]['Name']        = 'GoDaddy Pro Sites Worker';
            $plugins[$this->slug]['Title']       = 'GoDaddy Pro Sites Worker';
        }

        if (!$this->brand->isActive()) {
            return $plugins;
        }

        if (!$this->brand->getName() && !$this->brand->getDescription() && !$this->brand->getAuthor() && !$this->brand->getAuthorUrl()) {
            return $plugins;
        }

        $plugins[$this->slug]['Name']        = $this->brand->getName();
        $plugins[$this->slug]['Title']       = $this->brand->getName();
        $plugins[$this->slug]['Description'] = $this->brand->getDescription();
        $plugins[$this->slug]['AuthorURI']   = $this->brand->getAuthorUrl();
        $plugins[$this->slug]['Author']      = $this->brand->getAuthor();
        $plugins[$this->slug]['AuthorName']  = $this->brand->getAuthor();
        $plugins[$this->slug]['PluginURI']   = '';

        return $plugins;
    }

    /**
     * @wp_filter all_plugins
     */
    public function pluginListFilter($plugins)
    {
        $queryParameters = $this->context->get('_GET');

        if (!empty($queryParameters['showWorker'])) {
            return $plugins;
        }

        if (!isset($plugins[$this->slug])) {
            return $plugins;
        }

        if ($this->context->optionGet('mwp_pro_connected') === 'mwp_20') {
            unset($plugins[$this->slug]);
        }

        if ($this->brand->isActive() && $this->brand->isHide()) {
            unset($plugins[$this->slug]);
        }

        return $plugins;
    }

    /**
     * @wp_filter show_advanced_plugins
     */
    public function muPluginListFilter($previousValue, $type)
    {
        // Drop-in's are filtered after MU plugins.
        if ($type !== 'dropins') {
            return $previousValue;
        }

        if (!$this->context->hasContextValue('plugins')) {
            return $previousValue;
        }

        $queryParameters = $this->context->get('_GET');
        $plugins         = &$this->context->getContextValue('plugins');

        if (!isset($plugins['mustuse'][$this->loaderName])) {
            return $previousValue;
        }

        $mwpProConnected = $this->context->optionGet('mwp_pro_connected');

        if ($mwpProConnected == true) {
            $plugins['mustuse'][$this->loaderName]['Name']        = 'GoDaddy Pro Sites Worker Loader';
            $plugins['mustuse'][$this->loaderName]['Title']       = 'GoDaddy Pro Sites Worker Loader';
            $plugins['mustuse'][$this->loaderName]['Description'] = 'This is automatically generated by the GoDaddy Pro Sites Worker plugin to increase performance and reliability. It is automatically disabled when disabling the main plugin.';
            $plugins['mustuse'][$this->loaderName]['AuthorURI']   = 'https://www.godaddy.com/pro/sites';
            $plugins['mustuse'][$this->loaderName]['Author']      = 'GoDaddy';
            $plugins['mustuse'][$this->loaderName]['AuthorName']  = 'GoDaddy';
            $plugins['mustuse'][$this->loaderName]['PluginURI']   = '';
        }

        if ($mwpProConnected === 'mwp_20' && empty($queryParameters['showWorker'])) {
            unset($plugins['mustuse'][$this->loaderName]);
            return $previousValue;
        }

        if (!$this->brand->isActive()) {
            return $previousValue;
        }

        if ($this->brand->isHide() && empty($queryParameters['showWorker'])) {
            unset($plugins['mustuse'][$this->loaderName]);
        } else {
            $plugins['mustuse'][$this->loaderName]['Name']        = $this->brand->getName();
            $plugins['mustuse'][$this->loaderName]['Title']       = $this->brand->getName();
            $plugins['mustuse'][$this->loaderName]['Description'] = $this->brand->getDescription();
            $plugins['mustuse'][$this->loaderName]['AuthorURI']   = $this->brand->getAuthorUrl();
            $plugins['mustuse'][$this->loaderName]['Author']      = $this->brand->getAuthor();
            $plugins['mustuse'][$this->loaderName]['AuthorName']  = $this->brand->getAuthor();
            $plugins['mustuse'][$this->loaderName]['PluginURI']   = '';
        }

        return $previousValue;
    }

    /**
     * @wp_filter
     */
    public function hidePluginDetails($meta, $slug)
    {
        if ($slug !== $this->slug) {
            return $meta;
        }

        if (!$this->brand->getName() && !$this->brand->getDescription() && !$this->brand->getAuthor() && !$this->brand->getAuthorUrl()) {
            return $meta;
        }

        foreach ($meta as $metaKey => $metaValue) {
            if (strpos($metaValue, sprintf('>%s<', $this->context->translate('View details'))) === false) {
                continue;
            }
            unset($meta[$metaKey]);
            break;
        }

        return $meta;
    }

    /**
     * @wp_filter debug_information
     */
    public function pluginGetHealthInfoFilter($info) {
        if (!$this->brand->isActive()){
            return $info;
        }

        if (!isset($info["wp-plugins-active"]) ||
            !isset($info["wp-plugins-active"]["fields"]) ||
            !isset($info["wp-plugins-active"]["fields"]["ManageWP - Worker"]) ||
            !isset($info["wp-mu-plugins"]) ||
            !isset($info["wp-mu-plugins"]["fields"]) ||
            !isset($info["wp-mu-plugins"]["fields"]["ManageWP - Worker Loader"])) {
            return $info;
        }

        if ($this->brand->isHide()) {
            unset($info["wp-plugins-active"]["fields"]["ManageWP - Worker"]);
            unset($info["wp-mu-plugins"]["fields"]["ManageWP - Worker Loader"]);
        } else {
            $this->reBrandWorkerForSiteHealth($info["wp-plugins-active"]["fields"]["ManageWP - Worker"]);
            $this->reBrandWorkerForSiteHealth($info["wp-mu-plugins"]["fields"]["ManageWP - Worker Loader"]);
        }

        return $info;
    }

    private function reBrandWorkerForSiteHealth(&$workerEntry) {
        $workerEntry["label"] = $this->brand->getName();
        $workerEntry["value"] = str_replace("GoDaddy", $this->brand->getAuthor(), $workerEntry["value"]);
        $workerEntry["debug"] = str_replace("GoDaddy", $this->brand->getAuthor(), $workerEntry["debug"]);
    }
}
