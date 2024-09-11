<?php
/**
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret or copyright law.
 * Redistribution of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from InnoCraft Ltd.
 *
 * @link    https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */
namespace Piwik\Plugins\LoginSaml;

use Piwik\Common;
use Piwik\Piwik;
use Piwik\Plugin;
use Piwik\Plugins\UsersManager\Model as UserModel;
use Piwik\Url;
use Exception;

/**
 * Class LoginSaml is main plugin class. It contains events mapping and custom vendors loading.
 *
 * @codeCoverageIgnore
 * @package Piwik\Plugins\LoginSaml
 */
class LoginSaml extends Plugin
{
    /**
     * @param null $pluginName
     */
    public function __construct($pluginName = null)
    {
        $this->loadVendors();

        parent::__construct($pluginName);
    }

    public function registerEvents()
    {
        return $this->getListHooksRegistered();
    }

    /**
     * Returns a list of hooks with associated event observers.
     *
     * Derived classes should use this method to associate callbacks with events.
     *
     * @return array
     */
    public function getListHooksRegistered()
    {
        return array(
            'AssetManager.getJavaScriptFiles'        => 'getJavaScriptFiles',
            'Template.loginNav'                      => 'loginNav',
            'Controller.Login.login'                 => 'dispatchLoginAction',
            'Controller.Login.logout'                => array(
                'before' => true,
                'function' => 'dispatchLogoutAction'
            ),
            'Controller.LoginLdap.logout'            => array(
                'before' => true,
                'function' => 'dispatchLogoutAction'
            ),
            'Controller.LoginHttpAuth.logout'        => array(
                'before' => true,
                'function' => 'dispatchLogoutAction'
            ),
            'API.Request.dispatch'                   => 'onApiRequestDispatch',
            'Request.dispatch'                       => 'onRequestDispatch',
            'Login.authenticate.successful'          => 'onLoginDone',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
        );
    }

    public function getClientSideTranslationKeys(&$translationKeys)
    {
        $translationKeys[] = 'LoginSaml_StatusSettings';
        $translationKeys[] = 'LoginSaml_STATUS';
        $translationKeys[] = 'LoginSaml_STATUSDescription';
        $translationKeys[] = 'LoginSaml_IdPSettings';
        $translationKeys[] = 'LoginSaml_IdPEntityId';
        $translationKeys[] = 'LoginSaml_IdPEntityIdDescription';
        $translationKeys[] = 'LoginSaml_IdPSSOURL';
        $translationKeys[] = 'LoginSaml_IdPSSOURLDescription';
        $translationKeys[] = 'LoginSaml_IdPSLOURL';
        $translationKeys[] = 'LoginSaml_IdPSLOURLDescription';
        $translationKeys[] = 'LoginSaml_IdPx509CERT';
        $translationKeys[] = 'LoginSaml_IdPx509CERTDescription';
        $translationKeys[] = 'LoginSaml_IdPx509CERT2';
        $translationKeys[] = 'LoginSaml_IdPx509CERTDescription2';
        $translationKeys[] = 'LoginSaml_IdPx509CERT3';
        $translationKeys[] = 'LoginSaml_IdPx509CERTDescription3';
        $translationKeys[] = 'LoginSaml_OptionsSettings';
        $translationKeys[] = 'LoginSaml_OptionsAUTOCREATE';
        $translationKeys[] = 'LoginSaml_OptionsAUTOCREATEDescription';
        $translationKeys[] = 'LoginSaml_OptionsPWCONFIRMATION';
        $translationKeys[] = 'LoginSaml_OptionsPWCONFIRMATIONDescription';
        $translationKeys[] = 'LoginSaml_OptionsBYPASS2FA';
        $translationKeys[] = 'LoginSaml_OptionsBYPASS2FADescription';
        $translationKeys[] = 'LoginSaml_NewUserDefaultSitesViewAccess';
        $translationKeys[] = 'LoginSaml_NewUserDefaultSitesViewAccessDescription';
        $translationKeys[] = 'LoginSaml_OptionsIDENTIFYFIELD';
        $translationKeys[] = 'LoginSaml_OptionsIDENTIFYFIELDDescription';
        $translationKeys[] = 'LoginSaml_OptionsENABLESLO';
        $translationKeys[] = 'LoginSaml_OptionsENABLESLODescription';
        $translationKeys[] = 'LoginSaml_OptionsFORCESAML';
        $translationKeys[] = 'LoginSaml_OptionsFORCESAMLescription';
        $translationKeys[] = 'LoginSaml_OptionsForceSAMLVersionDesc';
        $translationKeys[] = 'LoginSaml_OptionsNORMALMODE';
        $translationKeys[] = 'LoginSaml_OptionsNORMALMODEDescription';
        $translationKeys[] = 'LoginSaml_EnableSamlSessionExpirationSynchronization';
        $translationKeys[] = 'LoginSaml_EnableSamlSessionExpirationSynchronizationDescription';
        $translationKeys[] = 'LoginSaml_AttributeMappingSettings';
        $translationKeys[] = 'LoginSaml_AttributeMappingUSERNAME';
        $translationKeys[] = 'LoginSaml_AttributeMappingUSERNAMEDescription';
        $translationKeys[] = 'LoginSaml_AttributeMappingEMAIL';
        $translationKeys[] = 'LoginSaml_AttributeMappingEMAILDescription';
        $translationKeys[] = 'LoginSaml_AccessSyncSettings';
        $translationKeys[] = 'LoginSaml_EnableSamlAccessSynchronization';
        $translationKeys[] = 'LoginSaml_EnableSamlAccessSynchronizationDescription';
        $translationKeys[] = 'LoginSaml_SamlViewAccessField';
        $translationKeys[] = 'LoginSaml_SamlViewAccessFieldDescription';
        $translationKeys[] = 'LoginSaml_SamlWriteAccessField';
        $translationKeys[] = 'LoginSaml_SamlWriteAccessFieldDescription';
        $translationKeys[] = 'LoginSaml_SamlAdminAccessField';
        $translationKeys[] = 'LoginSaml_SamlAdminAccessFieldDescription';
        $translationKeys[] = 'LoginSaml_SamlSuperUserAccessField';
        $translationKeys[] = 'LoginSaml_SamlSuperUserAccessFieldDescription';
        $translationKeys[] = 'LoginSaml_SamlUserAccessAttributeServerSpecDelimiter';
        $translationKeys[] = 'LoginSaml_SamlUserAccessAttributeServerSpecDelimiterDescription';
        $translationKeys[] = 'LoginSaml_SamlUserAccessAttributeServerSeparator';
        $translationKeys[] = 'LoginSaml_SamlUserAccessAttributeServerSeparatorDescription';
        $translationKeys[] = 'LoginSaml_ThisPiwikInstanceName';
        $translationKeys[] = 'LoginSaml_ThisPiwikInstanceNameDescription';
        $translationKeys[] = 'LoginSaml_AdvancedSettings';
        $translationKeys[] = 'LoginSaml_AdvancedSTRICT';
        $translationKeys[] = 'LoginSaml_AdvancedSTRICTDescription';
        $translationKeys[] = 'LoginSaml_AdvancedDEBUG';
        $translationKeys[] = 'LoginSaml_AdvancedDEBUGDescription';
        $translationKeys[] = 'LoginSaml_AdvancedSPENTITYID';
        $translationKeys[] = 'LoginSaml_AdvancedSPENTITYIDDescription';
        $translationKeys[] = 'LoginSaml_AdvancedNAMEIDFORMAT';
        $translationKeys[] = 'LoginSaml_AdvancedNAMEIDFORMATDescription';
        $translationKeys[] = 'LoginSaml_AdvancedNAMEIDENCRYPTED';
        $translationKeys[] = 'LoginSaml_AdvancedNAMEIDENCRYPTEDDescription';
        $translationKeys[] = 'LoginSaml_AdvancedAUTHNREQUESTSIGNED';
        $translationKeys[] = 'LoginSaml_AdvancedAUTHNREQUESTSIGNEDDescription';
        $translationKeys[] = 'LoginSaml_AdvancedLOGOUTREQUESTSIGNED';
        $translationKeys[] = 'LoginSaml_AdvancedLOGOUTREQUESTSIGNEDDescription';
        $translationKeys[] = 'LoginSaml_AdvancedLOGOUTRESPONSESIGNED';
        $translationKeys[] = 'LoginSaml_AdvancedLOGOUTRESPONSESIGNEDDescription';
        $translationKeys[] = 'LoginSaml_AdvancedMETADATASIGNED';
        $translationKeys[] = 'LoginSaml_AdvancedMETADATASIGNEDDescription';
        $translationKeys[] = 'LoginSaml_AdvancedWANTMESSAGESIGNED';
        $translationKeys[] = 'LoginSaml_AdvancedWANTMESSAGESIGNEDDescription';
        $translationKeys[] = 'LoginSaml_AdvancedREQUESTEDAUTHNCONTEXT';
        $translationKeys[] = 'LoginSaml_AdvancedREQUESTEDAUTHNCONTEXTDescription';
        $translationKeys[] = 'LoginSaml_AdvancedWANTASSERTIONSIGNED';
        $translationKeys[] = 'LoginSaml_AdvancedWANTASSERTIONSIGNEDDescription';
        $translationKeys[] = 'LoginSaml_AdvancedWANTASSERTIONENCRYPTED';
        $translationKeys[] = 'LoginSaml_AdvancedWANTASSERTIONENCRYPTEDDescription';
        $translationKeys[] = 'LoginSaml_AdvancedWANTNAMEIDENCRYPTED';
        $translationKeys[] = 'LoginSaml_AdvancedWANTNAMEIDENCRYPTEDDescription';
        $translationKeys[] = 'LoginSaml_AdvancedRETRIEVEFROMSERVER';
        $translationKeys[] = 'LoginSaml_AdvancedRETRIEVEFROMSERVERDescription';
        $translationKeys[] = 'LoginSaml_AdvancedSETPROXYVARS';
        $translationKeys[] = 'LoginSaml_AdvancedSETPROXYVARSDescription';
        $translationKeys[] = 'LoginSaml_AdvancedSPx509CERT';
        $translationKeys[] = 'LoginSaml_AdvancedSPx509CERTDescription';
        $translationKeys[] = 'LoginSaml_AdvancedSPPRIVATEKEY';
        $translationKeys[] = 'LoginSaml_AdvancedSPPRIVATEKEYDescription';
        $translationKeys[] = 'LoginSaml_AdvancedSIGNATUREALGORITHM';
        $translationKeys[] = 'LoginSaml_AdvancedSIGNATUREALGORITHMDescription';
        $translationKeys[] = 'LoginSaml_AdvancedDIGESTALGORITM';
        $translationKeys[] = 'LoginSaml_AdvancedDIGESTALGORITMDescription';
        $translationKeys[] = 'LoginSaml_AdvancedUSEFRIENDLYNAME';
        $translationKeys[] = 'LoginSaml_AdvancedUSEFRIENDLYNAMEDescription';
        $translationKeys[] = 'LoginSaml_AdvancedUSEFRIENDLYNAMEDescriptionNote';
        $translationKeys[] = 'LoginSaml_METADATALINK';
        $translationKeys[] = 'LoginSaml_IMPORTLINK';
        $translationKeys[] = 'LoginSaml_ReadMoreAboutAccessSynchronization';
        $translationKeys[] = 'LoginSaml_ExpectedSamlAttributes';
        $translationKeys[] = 'LoginSaml_ExpectedSamlAttributesPrelude';
        $translationKeys[] = 'LoginSaml_ImportMetadataTitle';
        $translationKeys[] = 'LoginSaml_GOBACKADMINLINK';
        $translationKeys[] = 'LoginSaml_ImportMetadataText';
        $translationKeys[] = 'LoginSaml_ImportIdPURL';
        $translationKeys[] = 'LoginSaml_ImportIdPURLDescription';
        $translationKeys[] = 'LoginSaml_ImportIdPXML';
        $translationKeys[] = 'LoginSaml_ImportIdPXMLDescription';
        $translationKeys[] = 'LoginSaml_ImportIdPEntityId';
        $translationKeys[] = 'LoginSaml_ImportIdPEntityIdDescription';
        $translationKeys[] = 'LoginSaml_SPMetadata';
        $translationKeys[] = 'LoginSaml_METADATAURLLINK_Description';
        $translationKeys[] = 'LoginSaml_METADATAURLLINK_Description2';
    }

    /**
     * Add plugin javascript files to Matomo assets.
     *
     * @param array &$jsFiles
     */
    public function getJavaScriptFiles(&$jsFiles)
    {
    }

    /**
     * Add link to SSO login page into Matomo login screen.
     *
     * @param string &$content
     * @param string $position
     */
    public function loginNav(&$content, $position)
    {
        $samlLoginUrl = "index.php?module=LoginSaml&action=singleSignOn";

        $referer = Url::getReferrer();
        if ($referer === false) {
            $referer = Url::getCurrentUrl();
        }
        if (Url::isLocalUrl($referer) &&
            strpos($referer, 'Login') === false &&
            strpos($referer, 'Logout') === false) {
            $samlLoginUrl .= "&target=".urlencode($referer);
        }

        $samlLoginBtn = '<a class="btn pull-right" href="' . $samlLoginUrl . '">' . Piwik::translate('LoginSaml_SamlLogin') . '</a>';

        if (Config::isForceSamlEnabled() && !isset($_GET['normal']) && (!isset($_GET['action']) || $_GET['action'] != 'confirmResetPassword')) {
            if (!empty($_GET['samlErrorMessage'])) {
                echo '<script>window.addEventListener("DOMContentLoaded", function () {$("#login_form").hide();})</script>';
                echo '<div vue-entry="CoreHome.Notification" noclear="true" context="error">'.htmlspecialchars($_GET['samlErrorMessage'], ENT_QUOTES, 'UTF-8').'</div>';
                echo $samlLoginBtn . '<br>';
                exit();
            } else if (empty($_POST) || empty($_POST["form_login"]) || empty($_POST["form_password"])) {
                Url::redirectToUrl($samlLoginUrl);
            }
        } else {
            if (Config::isForceSamlEnabled() && isset($_GET['normal'])) {
                $modeNormal = Config::getModeNormal();
                if (!empty($modeNormal)) {
                    if ($_GET['normal'] != $modeNormal) {
                        Url::redirectToUrl($samlLoginUrl);
                        exit();
                    }
                }
            }

            switch ($position) {
                case 'top':
                    if (!empty($_GET['samlErrorMessage'])) {
                        $content .= '<div vue-entry="CoreHome.Notification" noclear="true" context="error">'.htmlspecialchars($_GET['samlErrorMessage'], ENT_QUOTES, 'UTF-8').'</div>';
                    }
                    if (Config::isSamlEnabled()) {
                        // Here is the point where I can force the SAML SSO
                        $content .= $samlLoginBtn;
                    }
                    break;
            }
        }
    }

    /**
     * Reroute login screen error message in redirection.
     *
     * @param array &$parameters
     */
    public function dispatchLoginAction(&$parameters)
    {
        if (!empty($_GET['errorMessage'])) {
            $parameters['messageNoAccess'] = urldecode($_GET['errorMessage']);
        }
    }

    public function dispatchLogoutAction(&$parameters)
    {
        if (Config::isSamlEnabled() && Config::isSamlSLOEnabled()) {
            if (!empty($_SESSION['saml_data']['saml_login'])) {
                $sloUrlToRedirect = Url::getCurrentUrlWithoutFileName().'index.php?module=LoginSaml&action=singleLogOut';
                Url::redirectToUrl($sloUrlToRedirect);
            }
        }
    }

    public function onApiRequestDispatch(&$parameters, $pluginName, $methodName)
    {
        $forceSAMLEnabled = Config::isForceSamlEnabled();
        $loggedUser = Piwik::getCurrentUserLogin();
        if ($pluginName == 'UsersManager' && $forceSAMLEnabled) {
            if ($methodName == 'updateUser' && !empty($parameters['password'])) {
                // Disable the ability to change password (and email)
                if (!Piwik::hasTheUserSuperUserAccess($loggedUser)) {
                    throw new Exception(Piwik::translate('LoginSaml_ForceSamlOnlySuperusersCanChangePassword'));
                }
            }
        }

        $optionsIdentifyField = Config::samlUsersIdentifiedBy();
        if ($optionsIdentifyField != 'username') {
            // Prevent the ability to change mail if it is used as identifier
            if ($methodName == 'updateUser' && !empty($parameters['email'])) {
                if (Piwik::getCurrentUserEmail() != $parameters['email'] && !Piwik::hasTheUserSuperUserAccess($loggedUser)) {
                    throw new Exception(Piwik::translate('LoginSaml_SamlOnlySuperusersCanChangeEmail'));
                }
            }
        }

    }

    public function onRequestDispatch($pluginName, $methodName, &$parameters)
    {
        $forceSAMLEnabled = Config::isForceSamlEnabled();
        if ($forceSAMLEnabled) {
            if ($pluginName == 'Login') {
                if (in_array($methodName, array('resetPasswordFirstStep','resetPassword', 'confirmResetPassword'))) {
                    $login = isset($_POST['form_login'])? $_POST['form_login'] : ($_GET['login'] ?? '');
                    if (empty($login) || !$this->checkIfLoginIsSuperUser($login)) {
                        throw new Exception("Reset Password is not allowed when Force SAML is enabled. Action only allowed for Super Users");
                    }
                } if ($methodName === 'logme') {
                    throw new Exception("Automatic login is not allowed when Force SAML is enabled.");
                }
            }
        }
    }

    // important to do this after a successful login otherwise unauthenticated users could tell if a user was
    // a superuser or not
    public function onLoginDone($login)
    {
        $forceSAMLEnabled = Config::isForceSamlEnabled();
        if (!$forceSAMLEnabled) {
            return;
        }

        if (!isset($_GET['normal'])) {
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->getUser($login);
        if (empty($user)) {
            $user = $userModel->getUserByEmail($login);
        }

        if (!$this->checkIfLoginIsSuperUser($login)) {
            throw new Exception("Only Super Users can login using the normal method.");
        }
    }

    private function checkIfLoginIsSuperUser($login)
    {
        $userModel = new UserModel();
        $user = $userModel->getUser($login);
        if (empty($user)) {
            $user = $userModel->getUserByEmail($login);
        }

        $isSuperuser = true;
        if (!empty($user) && (!isset($user['superuser_access']) || $user['superuser_access'] != 1)) {
            $isSuperuser = false;
        }

        return $isSuperuser;
    }

    /**
     * Load plugin vendors.
     */
    private function loadVendors()
    {
        require_once __DIR__ . '/vendor/autoload.php';
    }
}
