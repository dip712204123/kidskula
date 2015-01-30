<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/student')) {
            // bundle_kidskula_homepage
            if ($pathinfo === '/student/find-friends') {
                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\LandingController::indexAction',  '_route' => 'bundle_kidskula_homepage',);
            }

            // bundle_search_data
            if ($pathinfo === '/student/getsuggestdata') {
                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\LandingController::autosuggestAction',  '_route' => 'bundle_search_data',);
            }

            if (0 === strpos($pathinfo, '/student/s')) {
                // frnd_search_index
                if ($pathinfo === '/student/search_friends') {
                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\LandingController::frndsearchAction',  '_route' => 'frnd_search_index',);
                }

                if (0 === strpos($pathinfo, '/student/student_addfriend')) {
                    // addfriend
                    if (rtrim($pathinfo, '/') === '/student/student_addfriend') {
                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'addfriend');
                        }

                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\AddfriendController::addfriendAction',  '_route' => 'addfriend',);
                    }

                    // cancelfriend
                    if ($pathinfo === '/student/student_addfriend/cancel') {
                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\AddfriendController::cancelfriendAction',  '_route' => 'cancelfriend',);
                    }

                    // acceptfriend
                    if ($pathinfo === '/student/student_addfriend/accept') {
                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\AddfriendController::acceptfriendAction',  '_route' => 'acceptfriend',);
                    }

                    // rejectfriend
                    if ($pathinfo === '/student/student_addfriend/reject') {
                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\AddfriendController::rejectfriendAction',  '_route' => 'rejectfriend',);
                    }

                    // unfriend
                    if ($pathinfo === '/student/student_addfriend/unfriend') {
                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\AddfriendController::unfriendAction',  '_route' => 'unfriend',);
                    }

                    if (0 === strpos($pathinfo, '/student/student_addfriend/in')) {
                        // intervalrequestcheck
                        if ($pathinfo === '/student/student_addfriend/intervalrequestcheck') {
                            return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\AddfriendController::intervalrequestcheckAction',  '_route' => 'intervalrequestcheck',);
                        }

                        // invitewithsecret
                        if ($pathinfo === '/student/student_addfriend/invitewithsecret') {
                            return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\AddfriendController::invitefrndsAction',  '_route' => 'invitewithsecret',);
                        }

                    }

                    // invitewithoutsecret
                    if ($pathinfo === '/student/student_addfriend/search') {
                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\AddfriendController::findfrndsAction',  '_route' => 'invitewithoutsecret',);
                    }

                    // invitenewfriends
                    if ($pathinfo === '/student/student_addfriend/invite_friends') {
                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\AddfriendController::invitenewfriendsAction',  '_route' => 'invitenewfriends',);
                    }

                    // friendRequestCheckForDivShow
                    if ($pathinfo === '/student/student_addfriend/friendRequestCheckForDivShow') {
                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\AddfriendController::friendrequestcheckAction',  '_route' => 'friendRequestCheckForDivShow',);
                    }

                }

            }

            // dashboard
            if (rtrim($pathinfo, '/') === '/student/user_dashboard') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'dashboard');
                }

                return array (  '_controller' => 'BundleKidskulaBundle:Dashboard:index',  '_route' => 'dashboard',);
            }

            // staticpages
            if (0 === strpos($pathinfo, '/student/pages') && preg_match('#^/student/pages/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'staticpages')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\StaticpagesController::indexAction',));
            }

            if (0 === strpos($pathinfo, '/student/home')) {
                // home
                if (rtrim($pathinfo, '/') === '/student/home') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'home');
                    }

                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\HomeController::indexAction',  '_route' => 'home',);
                }

                // friend_home
                if (0 === strpos($pathinfo, '/student/home/friend') && preg_match('#^/student/home/friend\\-(?P<username>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'friend_home')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\HomeController::friendhomeAction',));
                }

                // profilestatus
                if ($pathinfo === '/student/home/savestatus') {
                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\HomeController::profilestatusAction',  '_route' => 'profilestatus',);
                }

                // allfriendlisting
                if ($pathinfo === '/student/home/allfriendlisting') {
                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\HomeController::allfriendlistingAction',  '_route' => 'allfriendlisting',);
                }

                // setavatarname
                if ($pathinfo === '/student/home/setavatarname') {
                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\HomeController::setavatarnameAction',  '_route' => 'setavatarname',);
                }

            }

            if (0 === strpos($pathinfo, '/student/profile')) {
                // profilesetting
                if (rtrim($pathinfo, '/') === '/student/profile') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'profilesetting');
                    }

                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ProfilesettingController::indexAction',  '_route' => 'profilesetting',);
                }

                // profilesidesetting
                if ($pathinfo === '/student/profile/proset') {
                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ProfilesettingController::settingAction',  '_route' => 'profilesidesetting',);
                }

                // profilechangepicture
                if ($pathinfo === '/student/profile/changepicture') {
                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ProfilesettingController::changepictureAction',  '_route' => 'profilechangepicture',);
                }

                // profilecroppicture
                if ($pathinfo === '/student/profile/image-crop') {
                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ProfilesettingController::imagecropAction',  '_route' => 'profilecroppicture',);
                }

                // profileavatar
                if ($pathinfo === '/student/profile/profileavatar') {
                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ProfilesettingController::avatarselectAction',  '_route' => 'profileavatar',);
                }

            }

            if (0 === strpos($pathinfo, '/student/c')) {
                if (0 === strpos($pathinfo, '/student/co')) {
                    if (0 === strpos($pathinfo, '/student/contact')) {
                        // mycontacts
                        if (rtrim($pathinfo, '/') === '/student/contact') {
                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'mycontacts');
                            }

                            return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ContactController::indexAction',  '_route' => 'mycontacts',);
                        }

                        if (0 === strpos($pathinfo, '/student/contact/get')) {
                            // get_question_font_category
                            if ($pathinfo === '/student/contact/getcategory') {
                                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ContactController::getcategoryAction',  '_route' => 'get_question_font_category',);
                            }

                            // get_question_font_sub_category
                            if ($pathinfo === '/student/contact/getsubcategory') {
                                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ContactController::getsubcategoryAction',  '_route' => 'get_question_font_sub_category',);
                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/student/collection')) {
                        // mycollection
                        if (rtrim($pathinfo, '/') === '/student/collection') {
                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'mycollection');
                            }

                            return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\CollectionController::indexAction',  '_route' => 'mycollection',);
                        }

                        if (0 === strpos($pathinfo, '/student/collection/mycollection_')) {
                            // mycollection_point_count
                            if ($pathinfo === '/student/collection/mycollection_point_count') {
                                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\CollectionController::mycollectionsAction',  '_route' => 'mycollection_point_count',);
                            }

                            if (0 === strpos($pathinfo, '/student/collection/mycollection_home')) {
                                // mycollection_home_listing
                                if ($pathinfo === '/student/collection/mycollection_home_listing') {
                                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\CollectionController::mycollectionsHomeListingAction',  '_route' => 'mycollection_home_listing',);
                                }

                                // mycollection_hometrade_button
                                if ($pathinfo === '/student/collection/mycollection_hometrade_button') {
                                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\CollectionController::mycollection_hometrade_buttonAction',  '_route' => 'mycollection_hometrade_button',);
                                }

                            }

                        }

                        // mycollection_trade
                        if (0 === strpos($pathinfo, '/student/collection/Auth') && preg_match('#^/student/collection/Auth(?P<id>[^/]+)exchange/collections\\-exchange$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'mycollection_trade')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\CollectionController::mycollection_tradeAction',));
                        }

                        if (0 === strpos($pathinfo, '/student/collection/mycollection_trade_')) {
                            // mycollection_trade_exchange
                            if ($pathinfo === '/student/collection/mycollection_trade_exchange') {
                                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\CollectionController::mycollection_trade_exchangeAction',  '_route' => 'mycollection_trade_exchange',);
                            }

                            // mycollection_trade_accpet
                            if ($pathinfo === '/student/collection/mycollection_trade_accpet') {
                                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\CollectionController::mycollection_trade_accpetAction',  '_route' => 'mycollection_trade_accpet',);
                            }

                            // mycollection_trade_reject
                            if ($pathinfo === '/student/collection/mycollection_trade_reject') {
                                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\CollectionController::mycollection_trade_rejectAction',  '_route' => 'mycollection_trade_reject',);
                            }

                        }

                    }

                }

                if (0 === strpos($pathinfo, '/student/club')) {
                    // myclub
                    if (rtrim($pathinfo, '/') === '/student/club') {
                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'myclub');
                        }

                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ClubController::indexAction',  '_route' => 'myclub',);
                    }

                    if (0 === strpos($pathinfo, '/student/club/view-')) {
                        // myclub_list
                        if ($pathinfo === '/student/club/view-myclubs') {
                            return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ClubController::clublistAction',  '_route' => 'myclub_list',);
                        }

                        // allclub_list
                        if ($pathinfo === '/student/club/view-clubs') {
                            return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ClubController::clublistAction',  '_route' => 'allclub_list',);
                        }

                    }

                    // myclub-details
                    if (preg_match('#^/student/club/(?P<id>[^/]++)/details$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'myclub-details')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ClubController::clubdetailsAction',));
                    }

                    // myclub-membership
                    if ($pathinfo === '/student/club/membership') {
                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ClubController::myclub_membershipAction',  '_route' => 'myclub-membership',);
                    }

                    if (0 === strpos($pathinfo, '/student/club/c')) {
                        // myarticle-add
                        if ($pathinfo === '/student/club/createarticle') {
                            return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ClubController::createarticleAction',  '_route' => 'myarticle-add',);
                        }

                        // commentlisting
                        if (0 === strpos($pathinfo, '/student/club/commentlisting') && preg_match('#^/student/club/commentlisting(?:/(?P<eventId>[^/]++)(?:/(?P<parentId>[^/]++))?)?$#s', $pathinfo, $matches)) {
                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'commentlisting')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ClubController::getdiscussionAction',  'eventId' => 0,  'parentId' => 0,));
                        }

                    }

                    // articlelisting
                    if (preg_match('#^/student/club/(?P<id>[^/]++)/(?P<status>[^/]++)/articlelisting$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'articlelisting')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ClubController::articlelistingAction',));
                    }

                    // recentarticlelisting
                    if (preg_match('#^/student/club/(?P<id>[^/]++)/(?P<articleid>[^/]++)/(?P<status>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'recentarticlelisting')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ClubController::articlelistingAction',));
                    }

                    // articlelike
                    if ($pathinfo === '/student/club/articlelike') {
                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ClubController::articlelikeAction',  '_route' => 'articlelike',);
                    }

                    // view-notification
                    if ($pathinfo === '/student/club/view-notification') {
                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ClubController::viewnotificationAction',  '_route' => 'view-notification',);
                    }

                    // student-club-log
                    if ($pathinfo === '/student/club/student-club-log') {
                        return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\ClubController::studentclublogAction',  '_route' => 'student-club-log',);
                    }

                }

            }

            // notificationSeen
            if ($pathinfo === '/student/front_notification/notificationSeen') {
                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\NotificationController::notificationSeenAction',  '_route' => 'notificationSeen',);
            }

            if (0 === strpos($pathinfo, '/student/log')) {
                // fornt_login
                if ($pathinfo === '/student/login') {
                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\LoginController::indexAction',  '_route' => 'fornt_login',);
                }

                // fornt_logout
                if ($pathinfo === '/student/loggedout') {
                    return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\LoginController::logoutAction',  '_route' => 'fornt_logout',);
                }

            }

            // fornt_forgotpassword
            if ($pathinfo === '/student/forgotpassword') {
                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\LoginController::forgotpasswordAction',  '_route' => 'fornt_forgotpassword',);
            }

            // fornt_student_activation
            if (preg_match('#^/student/(?P<token>[^/]++)/student_activation$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'fornt_student_activation')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\RegistrationController::student_activationAction',));
            }

            // fornt_forgot_passowrd_link
            if (preg_match('#^/student/(?P<token>[^/]++)/reset\\-password$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'fornt_forgot_passowrd_link')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\LoginController::resetAction',));
            }

            // fornt_registration
            if ($pathinfo === '/student/registration') {
                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\RegistrationController::indexAction',  '_route' => 'fornt_registration',);
            }

            // fornt_auth_registration
            if (0 === strpos($pathinfo, '/student/auth_registration') && preg_match('#^/student/auth_registration/(?P<auth>[^/]++)/?$#s', $pathinfo, $matches)) {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fornt_auth_registration');
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'fornt_auth_registration')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\RegistrationController::indexAction',));
            }

            // setsession
            if ($pathinfo === '/student/loading') {
                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\LoginController::setsessionAction',  '_route' => 'setsession',);
            }

            // sendmessage
            if ($pathinfo === '/student/sendmessage') {
                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\HomeController::sendmessageAction',  '_route' => 'sendmessage',);
            }

            // messagedetails
            if (0 === strpos($pathinfo, '/student/messagedetails') && preg_match('#^/student/messagedetails\\-(?P<messageid>[^/\\-]++)\\-(?P<replyid>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'messagedetails')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\HomeController::messagedetailsAction',));
            }

            // replymessage
            if (0 === strpos($pathinfo, '/student/replymessage') && preg_match('#^/student/replymessage\\-(?P<messageid>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'replymessage')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\HomeController::replymessageAction',));
            }

            // messagelist
            if ($pathinfo === '/student/messagelist') {
                return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\HomeController::messagelistAction',  '_route' => 'messagelist',);
            }

        }

        // bundle_common
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'bundle_common');
            }

            return array (  '_controller' => 'Bundle\\CommonBundle\\Controller\\IndexController::indexAction',  '_route' => 'bundle_common',);
        }

        // registration
        if ($pathinfo === '/webservice/student-registration') {
            return array (  '_controller' => 'Bundle\\CommonBundle\\Controller\\WebserviceController::indexAction',  '_route' => 'registration',);
        }

        if (0 === strpos($pathinfo, '/parent')) {
            if (0 === strpos($pathinfo, '/parent/home')) {
                // parent-home
                if (rtrim($pathinfo, '/') === '/parent/home') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'parent-home');
                    }

                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\HomeController::indexAction',  '_route' => 'parent-home',);
                }

                // frndrequestcheck
                if ($pathinfo === '/parent/home/frndrequestcheck') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\HomeController::frndrequestcheckAction',  '_route' => 'frndrequestcheck',);
                }

                // allowfriend
                if ($pathinfo === '/parent/home/allowfriend') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\HomeController::allowfriendAction',  '_route' => 'allowfriend',);
                }

            }

            if (0 === strpos($pathinfo, '/parent/profile')) {
                // profile
                if (rtrim($pathinfo, '/') === '/parent/profile') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'profile');
                    }

                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ProfilesettingController::profileAction',  '_route' => 'profile',);
                }

                // parent_profilesetting
                if ($pathinfo === '/parent/profile/settings') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ProfilesettingController::indexAction',  '_route' => 'parent_profilesetting',);
                }

                // parent_profilesidesetting
                if ($pathinfo === '/parent/profile/proset') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ProfilesettingController::settingAction',  '_route' => 'parent_profilesidesetting',);
                }

                // parent_profilechangepicture
                if ($pathinfo === '/parent/profile/changepicture') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ProfilesettingController::changepictureAction',  '_route' => 'parent_profilechangepicture',);
                }

                // parent_profilecroppicture
                if ($pathinfo === '/parent/profile/image-crop') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ProfilesettingController::imagecropAction',  '_route' => 'parent_profilecroppicture',);
                }

                // parent_profileavatar
                if ($pathinfo === '/parent/profile/profileavatar') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ProfilesettingController::avatarselectAction',  '_route' => 'parent_profileavatar',);
                }

                // parent_profilestatus
                if ($pathinfo === '/parent/profile/savestatus') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ProfilesettingController::profilestatusAction',  '_route' => 'parent_profilestatus',);
                }

                // parentallfriendlisting
                if ($pathinfo === '/parent/profile/allfriendlisting') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ProfilesettingController::allfriendlistingAction',  '_route' => 'parentallfriendlisting',);
                }

            }

            // childprofile
            if (0 === strpos($pathinfo, '/parent/child-profile') && preg_match('#^/parent/child\\-profile/(?P<username>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'childprofile')), array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ChildprofileController::indexAction',));
            }

            // parent_logout
            if ($pathinfo === '/parent/loggedout') {
                return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ParentLoginController::logoutAction',  '_route' => 'parent_logout',);
            }

            if (0 === strpos($pathinfo, '/parent/parent_addfriend')) {
                // parent_addfriend
                if (rtrim($pathinfo, '/') === '/parent/parent_addfriend') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'parent_addfriend');
                    }

                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\AddfriendController::addfriendAction',  '_route' => 'parent_addfriend',);
                }

                // parent_cancelfriend
                if ($pathinfo === '/parent/parent_addfriend/cancel') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\AddfriendController::cancelfriendAction',  '_route' => 'parent_cancelfriend',);
                }

                // parent_acceptfriend
                if ($pathinfo === '/parent/parent_addfriend/accept') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\AddfriendController::acceptfriendAction',  '_route' => 'parent_acceptfriend',);
                }

                // parent_rejectfriend
                if ($pathinfo === '/parent/parent_addfriend/reject') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\AddfriendController::rejectfriendAction',  '_route' => 'parent_rejectfriend',);
                }

                // parent_unfriend
                if ($pathinfo === '/parent/parent_addfriend/unfriend') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\AddfriendController::unfriendAction',  '_route' => 'parent_unfriend',);
                }

                if (0 === strpos($pathinfo, '/parent/parent_addfriend/in')) {
                    // parent_intervalrequestcheck
                    if ($pathinfo === '/parent/parent_addfriend/intervalrequestcheck') {
                        return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\AddfriendController::intervalrequestcheckAction',  '_route' => 'parent_intervalrequestcheck',);
                    }

                    // parent_invitewithsecret
                    if ($pathinfo === '/parent/parent_addfriend/invitewithsecret') {
                        return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\AddfriendController::invitefrndsAction',  '_route' => 'parent_invitewithsecret',);
                    }

                }

                // parent_invitewithoutsecret
                if ($pathinfo === '/parent/parent_addfriend/search') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\AddfriendController::findfrndsAction',  '_route' => 'parent_invitewithoutsecret',);
                }

                // parent_invitenewfriends
                if ($pathinfo === '/parent/parent_addfriend/invite_friends') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\AddfriendController::invitenewfriendsAction',  '_route' => 'parent_invitenewfriends',);
                }

                // parent_friendRequestCheckForDivShow
                if ($pathinfo === '/parent/parent_addfriend/friendRequestCheckForDivShow') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\AddfriendController::friendrequestcheckAction',  '_route' => 'parent_friendRequestCheckForDivShow',);
                }

            }

            // parent_forgotpassword
            if ($pathinfo === '/parent/forgotpassword') {
                return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ParentLoginController::forgotpasswordAction',  '_route' => 'parent_forgotpassword',);
            }

            // parent_registration
            if ($pathinfo === '/parent/registration') {
                return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\RegistrationController::indexAction',  '_route' => 'parent_registration',);
            }

            // parent_auth_registration
            if (0 === strpos($pathinfo, '/parent/auth_registration') && preg_match('#^/parent/auth_registration/(?P<auth>[^/]++)/?$#s', $pathinfo, $matches)) {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'parent_auth_registration');
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'parent_auth_registration')), array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\RegistrationController::indexAction',));
            }

            // parent_activation
            if (preg_match('#^/parent/(?P<token>[^/]++)/parent_activation$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'parent_activation')), array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\RegistrationController::parent_activationAction',));
            }

            // showchildmessage
            if ($pathinfo === '/parent/showchildmessage') {
                return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ChildprofileController::showchildmessageAction',  '_route' => 'showchildmessage',);
            }

            if (0 === strpos($pathinfo, '/parent/club')) {
                // parentclub
                if (rtrim($pathinfo, '/') === '/parent/club') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'parentclub');
                    }

                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ClubController::indexAction',  '_route' => 'parentclub',);
                }

                // parentclub_list
                if ($pathinfo === '/parent/club/view-myclubs') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ClubController::clublistAction',  '_route' => 'parentclub_list',);
                }

                // parentclub-details
                if (preg_match('#^/parent/club/(?P<id>[^/]++)/details$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'parentclub-details')), array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ClubController::clubdetailsAction',));
                }

                // parentclub-membership
                if ($pathinfo === '/parent/club/membership') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ClubController::myclub_membershipAction',  '_route' => 'parentclub-membership',);
                }

                if (0 === strpos($pathinfo, '/parent/club/c')) {
                    // parentarticle-add
                    if ($pathinfo === '/parent/club/createarticle') {
                        return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ClubController::createarticleAction',  '_route' => 'parentarticle-add',);
                    }

                    // parentcommentlisting
                    if (0 === strpos($pathinfo, '/parent/club/commentlisting') && preg_match('#^/parent/club/commentlisting(?:/(?P<eventId>[^/]++)(?:/(?P<parentId>[^/]++))?)?$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'parentcommentlisting')), array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ClubController::getdiscussionAction',  'eventId' => 0,  'parentId' => 0,));
                    }

                }

                // parentarticlelisting
                if (preg_match('#^/parent/club/(?P<id>[^/]++)/(?P<status>[^/]++)/articlelisting$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'parentarticlelisting')), array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ClubController::articlelistingAction',));
                }

                // parentrecentarticlelisting
                if (preg_match('#^/parent/club/(?P<id>[^/]++)/(?P<articleid>[^/]++)/(?P<status>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'parentrecentarticlelisting')), array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ClubController::articlelistingAction',));
                }

                // parentarticlelike
                if ($pathinfo === '/parent/club/articlelike') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ClubController::articlelikeAction',  '_route' => 'parentarticlelike',);
                }

                // parentview-notification
                if ($pathinfo === '/parent/club/view-notification') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ClubController::viewnotificationAction',  '_route' => 'parentview-notification',);
                }

                // parent-club-log
                if ($pathinfo === '/parent/club/student-club-log') {
                    return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ClubController::studentclublogAction',  '_route' => 'parent-club-log',);
                }

            }

        }

        // bundle_kidskula
        if ($pathinfo === '/students') {
            return array (  '_controller' => 'Bundle\\KidskulaBundle\\Controller\\LandingController::indexAction',  '_route' => 'bundle_kidskula',);
        }

        // kidskula_bundle_parents
        if ($pathinfo === '/parents') {
            return array (  '_controller' => 'Bundle\\ParentBundle\\Controller\\ParentLoginController::indexAction',  '_route' => 'kidskula_bundle_parents',);
        }

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // fos_user_security_login
                if ($pathinfo === '/login') {
                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
                }

                // fos_user_security_check
                if ($pathinfo === '/login_check') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_security_check;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
                }
                not_fos_user_security_check:

            }

            // fos_user_security_logout
            if ($pathinfo === '/logout') {
                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
            }

        }

        if (0 === strpos($pathinfo, '/resetting')) {
            // fos_user_resetting_request
            if ($pathinfo === '/resetting/request') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_resetting_request;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::requestAction',  '_route' => 'fos_user_resetting_request',);
            }
            not_fos_user_resetting_request:

            // fos_user_resetting_send_email
            if ($pathinfo === '/resetting/send-email') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_fos_user_resetting_send_email;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
            }
            not_fos_user_resetting_send_email:

            // fos_user_resetting_check_email
            if ($pathinfo === '/resetting/check-email') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_resetting_check_email;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
            }
            not_fos_user_resetting_check_email:

            // fos_user_resetting_reset
            if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_resetting_reset;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::resetAction',));
            }
            not_fos_user_resetting_reset:

        }

        if (0 === strpos($pathinfo, '/group')) {
            // fos_user_group_list
            if ($pathinfo === '/group/list') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_group_list;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\GroupController::listAction',  '_route' => 'fos_user_group_list',);
            }
            not_fos_user_group_list:

            // fos_user_group_new
            if ($pathinfo === '/group/new') {
                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\GroupController::newAction',  '_route' => 'fos_user_group_new',);
            }

            // fos_user_group_show
            if (preg_match('#^/group/(?P<groupName>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_group_show;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_group_show')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\GroupController::showAction',));
            }
            not_fos_user_group_show:

            // fos_user_group_edit
            if (preg_match('#^/group/(?P<groupName>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_group_edit')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\GroupController::editAction',));
            }

            // fos_user_group_delete
            if (preg_match('#^/group/(?P<groupName>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_group_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_group_delete')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\GroupController::deleteAction',));
            }
            not_fos_user_group_delete:

        }

        if (0 === strpos($pathinfo, '/admin')) {
            if (0 === strpos($pathinfo, '/admin/register')) {
                // fos_user_registration_register
                if (rtrim($pathinfo, '/') === '/admin/register') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'fos_user_registration_register');
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\RegistrationController::registerAction',  '_route' => 'fos_user_registration_register',);
                }

                if (0 === strpos($pathinfo, '/admin/register/c')) {
                    // fos_user_registration_check_email
                    if ($pathinfo === '/admin/register/check-email') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_check_email;
                        }

                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\RegistrationController::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                    }
                    not_fos_user_registration_check_email:

                    if (0 === strpos($pathinfo, '/admin/register/confirm')) {
                        // fos_user_registration_confirm
                        if (preg_match('#^/admin/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirm;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\RegistrationController::confirmAction',));
                        }
                        not_fos_user_registration_confirm:

                        // fos_user_registration_confirmed
                        if ($pathinfo === '/admin/register/confirmed') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirmed;
                            }

                            return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\RegistrationController::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                        }
                        not_fos_user_registration_confirmed:

                    }

                }

            }

            // bundle_admin_homepage
            if (rtrim($pathinfo, '/') === '/admin') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'bundle_admin_homepage');
                }

                return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\DefaultController::indexAction',  '_route' => 'bundle_admin_homepage',);
            }

            // bundle_admin_logincheck
            if ($pathinfo === '/admin/login') {
                return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\UserController::loginAction',  '_route' => 'bundle_admin_logincheck',);
            }

            // bundle_admin_dashboard
            if ($pathinfo === '/admin/dashboard') {
                return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\DefaultController::indexAction',  '_route' => 'bundle_admin_dashboard',);
            }

            // bundle_admin_logout
            if ($pathinfo === '/admin/logout') {
                return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\UserController::logoutAction',  '_route' => 'bundle_admin_logout',);
            }

            // bundle_admin_user
            if ($pathinfo === '/admin/user') {
                return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaUserController::indexAction',  '_route' => 'bundle_admin_user',);
            }

            if (0 === strpos($pathinfo, '/admin/profile')) {
                // profile_details
                if (rtrim($pathinfo, '/') === '/admin/profile') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'profile_details');
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ProfileController::indexAction',  '_route' => 'profile_details',);
                }

                // profile_details_edit
                if ($pathinfo === '/admin/profile/edit') {
                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ProfileController::editAction',  '_route' => 'profile_details_edit',);
                }

                if (0 === strpos($pathinfo, '/admin/profile/changep')) {
                    // profile_changepass
                    if ($pathinfo === '/admin/profile/changepassword') {
                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ProfileController::changepassAction',  '_route' => 'profile_changepass',);
                    }

                    // profile_changepicture
                    if ($pathinfo === '/admin/profile/changepicture') {
                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ProfileController::changepictureAction',  '_route' => 'profile_changepicture',);
                    }

                }

                // profile_croppicture
                if ($pathinfo === '/admin/profile/image-crop') {
                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ProfileController::imagecropAction',  '_route' => 'profile_croppicture',);
                }

                // profile_activetab
                if ($pathinfo === '/admin/profile/activetab') {
                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ProfileController::activetabAction',  '_route' => 'profile_activetab',);
                }

            }

            if (0 === strpos($pathinfo, '/admin/email_notification')) {
                // kidskulaemailnotification
                if (rtrim($pathinfo, '/') === '/admin/email_notification') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'kidskulaemailnotification');
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaEmailNotificationController::indexAction',  '_route' => 'kidskulaemailnotification',);
                }

                // kidskulaemailnotification_create
                if ($pathinfo === '/admin/email_notification/create') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_kidskulaemailnotification_create;
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaEmailNotificationController::createAction',  '_route' => 'kidskulaemailnotification_create',);
                }
                not_kidskulaemailnotification_create:

                // kidskulaemailnotification_new
                if ($pathinfo === '/admin/email_notification/new') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_kidskulaemailnotification_new;
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaEmailNotificationController::newAction',  '_route' => 'kidskulaemailnotification_new',);
                }
                not_kidskulaemailnotification_new:

                // kidskulaemailnotification_show
                if (preg_match('#^/admin/email_notification/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_kidskulaemailnotification_show;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'kidskulaemailnotification_show')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaEmailNotificationController::showAction',));
                }
                not_kidskulaemailnotification_show:

                // kidskulaemailnotification_edit
                if (preg_match('#^/admin/email_notification/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_kidskulaemailnotification_edit;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'kidskulaemailnotification_edit')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaEmailNotificationController::editAction',));
                }
                not_kidskulaemailnotification_edit:

                // kidskulaemailnotification_update
                if (preg_match('#^/admin/email_notification/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_kidskulaemailnotification_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'kidskulaemailnotification_update')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaEmailNotificationController::updateAction',));
                }
                not_kidskulaemailnotification_update:

                // kidskulaemailnotification_delete
                if (preg_match('#^/admin/email_notification/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_kidskulaemailnotification_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'kidskulaemailnotification_delete')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaEmailNotificationController::deleteAction',));
                }
                not_kidskulaemailnotification_delete:

            }

            if (0 === strpos($pathinfo, '/admin/static_page_list')) {
                // static_page_list
                if (rtrim($pathinfo, '/') === '/admin/static_page_list') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'static_page_list');
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStaticMenusController::indexAction',  '_route' => 'static_page_list',);
                }

                // static_page_add
                if ($pathinfo === '/admin/static_page_list/add') {
                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStaticMenusController::newAction',  '_route' => 'static_page_add',);
                }

                // static_page_edit
                if (preg_match('#^/admin/static_page_list/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'static_page_edit')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStaticMenusController::editAction',));
                }

                // static_page_update
                if (preg_match('#^/admin/static_page_list/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                        $allow = array_merge($allow, array('POST', 'PUT'));
                        goto not_static_page_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'static_page_update')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStaticMenusController::updateAction',));
                }
                not_static_page_update:

                // static_page_status
                if (preg_match('#^/admin/static_page_list/(?P<id>[^/]++)/status$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'static_page_status')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStaticMenusController::statusAction',));
                }

                // static_page_form_create
                if ($pathinfo === '/admin/static_page_list/static_page_form_create') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_static_page_form_create;
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStaticMenusController::createAction',  '_route' => 'static_page_form_create',);
                }
                not_static_page_form_create:

            }

            if (0 === strpos($pathinfo, '/admin/manageuser')) {
                // manageuser
                if (rtrim($pathinfo, '/') === '/admin/manageuser') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'manageuser');
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidskulaUserController::indexAction',  '_route' => 'manageuser',);
                }

                // user_status
                if (preg_match('#^/admin/manageuser/(?P<id>[^/]++)/status$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_status')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaUserController::statusAction',));
                }

                // user_detail
                if (preg_match('#^/admin/manageuser/(?P<id>[^/]++)/user_details$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_detail')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaUserController::showAction',));
                }

                // user_settings
                if (preg_match('#^/admin/manageuser/(?P<id>[^/]++)/settings$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_settings')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaUserController::settingsAction',));
                }

                if (0 === strpos($pathinfo, '/admin/manageuser/new')) {
                    // user_new
                    if ($pathinfo === '/admin/manageuser/new') {
                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaUserController::newAction',  '_route' => 'user_new',);
                    }

                    // user_form_create
                    if ($pathinfo === '/admin/manageuser/newuser_form_create') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_user_form_create;
                        }

                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaUserController::createAction',  '_route' => 'user_form_create',);
                    }
                    not_user_form_create:

                }

                if (0 === strpos($pathinfo, '/admin/manageuser/user_')) {
                    // user_settings_edit
                    if (0 === strpos($pathinfo, '/admin/manageuser/user_update') && preg_match('#^/admin/manageuser/user_update/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_user_settings_edit;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_settings_edit')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaUserController::edituserAction',));
                    }
                    not_user_settings_edit:

                    // user_parental_settings
                    if (0 === strpos($pathinfo, '/admin/manageuser/user_parental_settings') && preg_match('#^/admin/manageuser/user_parental_settings/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'user_parental_settings')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaUserController::parentalsettingsAction',));
                    }

                }

            }

            if (0 === strpos($pathinfo, '/admin/contactus')) {
                // contact_us
                if (rtrim($pathinfo, '/') === '/admin/contactus') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'contact_us');
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactusController::indexAction',  '_route' => 'contact_us',);
                }

                // contact_us_delete
                if (preg_match('#^/admin/contactus/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'contact_us_delete')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactusController::deleteAction',));
                }

                // contact_us_show
                if (preg_match('#^/admin/contactus/(?P<id>[^/]++)/details$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'contact_us_show')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactusController::showAction',));
                }

            }

            if (0 === strpos($pathinfo, '/admin/s')) {
                if (0 === strpos($pathinfo, '/admin/student_grade')) {
                    // student_grade
                    if (rtrim($pathinfo, '/') === '/admin/student_grade') {
                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'student_grade');
                        }

                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStudentGradeController::indexAction',  '_route' => 'student_grade',);
                    }

                    // student_grade_status
                    if (preg_match('#^/admin/student_grade/(?P<id>[^/]++)/grade_status$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'student_grade_status')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStudentGradeController::statusAction',));
                    }

                    if (0 === strpos($pathinfo, '/admin/student_grade/new')) {
                        // student_grade_new
                        if ($pathinfo === '/admin/student_grade/new') {
                            return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStudentGradeController::newAction',  '_route' => 'student_grade_new',);
                        }

                        // student_grade_form_create
                        if ($pathinfo === '/admin/student_grade/newgrade_form_create') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_student_grade_form_create;
                            }

                            return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStudentGradeController::createAction',  '_route' => 'student_grade_form_create',);
                        }
                        not_student_grade_form_create:

                    }

                    // student_grade_edit
                    if (preg_match('#^/admin/student_grade/(?P<id>[^/]++)/grade_edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'student_grade_edit')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStudentGradeController::editAction',));
                    }

                    // student_grade_update
                    if (preg_match('#^/admin/student_grade/(?P<id>[^/]++)/grade_update$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'student_grade_update')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStudentGradeController::updateAction',));
                    }

                    // student_grade_delete
                    if (preg_match('#^/admin/student_grade/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'student_grade_delete')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaStudentGradeController::deleteAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/school')) {
                    // school
                    if (rtrim($pathinfo, '/') === '/admin/school') {
                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'school');
                        }

                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaSchoolController::indexAction',  '_route' => 'school',);
                    }

                    // school_status
                    if (preg_match('#^/admin/school/(?P<id>[^/]++)/school_status$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'school_status')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaSchoolController::statusAction',));
                    }

                    if (0 === strpos($pathinfo, '/admin/school/new')) {
                        // school_new
                        if ($pathinfo === '/admin/school/new') {
                            return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaSchoolController::newAction',  '_route' => 'school_new',);
                        }

                        // school_form_create
                        if ($pathinfo === '/admin/school/newschool_form_create') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_school_form_create;
                            }

                            return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaSchoolController::createAction',  '_route' => 'school_form_create',);
                        }
                        not_school_form_create:

                    }

                    // school_edit
                    if (preg_match('#^/admin/school/(?P<id>[^/]++)/school_edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'school_edit')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaSchoolController::editAction',));
                    }

                    // school_update
                    if (preg_match('#^/admin/school/(?P<id>[^/]++)/grade_update$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'school_update')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaSchoolController::updateAction',));
                    }

                    // school_delete
                    if (preg_match('#^/admin/school/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'school_delete')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\KidsKulaSchoolController::deleteAction',));
                    }

                }

            }

            if (0 === strpos($pathinfo, '/admin/collection')) {
                // allcollection
                if (rtrim($pathinfo, '/') === '/admin/collection') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'allcollection');
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::indexAction',  '_route' => 'allcollection',);
                }

                // collection_add
                if ($pathinfo === '/admin/collection/add') {
                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::newAction',  '_route' => 'collection_add',);
                }

                // collection_upload
                if ($pathinfo === '/admin/collection/upload') {
                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::uploadAction',  '_route' => 'collection_upload',);
                }

                if (0 === strpos($pathinfo, '/admin/collection/s')) {
                    // collection_subcatdrop
                    if ($pathinfo === '/admin/collection/subcatdrop') {
                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::subcatdropAction',  '_route' => 'collection_subcatdrop',);
                    }

                    // collection_save
                    if ($pathinfo === '/admin/collection/save') {
                        if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                            $allow = array_merge($allow, array('POST', 'PUT'));
                            goto not_collection_save;
                        }

                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::saveAction',  '_route' => 'collection_save',);
                    }
                    not_collection_save:

                }

                // collection_status
                if (preg_match('#^/admin/collection/(?P<id>[^/]++)/status$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'collection_status')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::statusAction',));
                }

                if (0 === strpos($pathinfo, '/admin/collection/category')) {
                    // collection_category
                    if ($pathinfo === '/admin/collection/category') {
                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::listcategoryAction',  '_route' => 'collection_category',);
                    }

                    if (0 === strpos($pathinfo, '/admin/collection/category_')) {
                        // category_add
                        if ($pathinfo === '/admin/collection/category_add') {
                            return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::categoryaddAction',  '_route' => 'category_add',);
                        }

                        // category_add_submit
                        if ($pathinfo === '/admin/collection/category_submit') {
                            return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::createAction',  '_route' => 'category_add_submit',);
                        }

                    }

                }

                // category_edit
                if (preg_match('#^/admin/collection/(?P<id>[^/]++)/category_edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_edit')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::editAction',));
                }

                // category_edit_submit
                if (preg_match('#^/admin/collection/(?P<id>[^/]++)/category_edit_submit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_edit_submit')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::updateAction',));
                }

                // category_delete
                if (preg_match('#^/admin/collection/(?P<id>[^/]++)/category_delete$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_delete')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::deleteAction',));
                }

                // category_status
                if (preg_match('#^/admin/collection/(?P<id>[^/]++)/category_status$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_status')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::categorystatusAction',));
                }

                // collection_subcategory
                if ($pathinfo === '/admin/collection/subcategory') {
                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::listsubcategoryAction',  '_route' => 'collection_subcategory',);
                }

                // add_collection_subcategory
                if ($pathinfo === '/admin/collection/add_subcategory') {
                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::addsubcategoryAction',  '_route' => 'add_collection_subcategory',);
                }

                // status_collection_subcategory
                if (preg_match('#^/admin/collection/(?P<id>[^/]++)/subcatstatus$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'status_collection_subcategory')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionController::subcatstatusAction',));
                }

                // collection_settings
                if (preg_match('#^/admin/collection/(?P<id>[^/]++)/rewardsetting$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'collection_settings')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionSettingsController::mailacceptAction',));
                }

                // collection_settings_save
                if (preg_match('#^/admin/collection/(?P<id>[^/]++)/savesetting$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'collection_settings_save')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\CollectionSettingsController::saveAction',));
                }

            }

            if (0 === strpos($pathinfo, '/admin/avatar')) {
                // allavatar
                if (rtrim($pathinfo, '/') === '/admin/avatar') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'allavatar');
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\AvatarController::indexAction',  '_route' => 'allavatar',);
                }

                // avatar_add
                if ($pathinfo === '/admin/avatar/add') {
                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\AvatarController::newAction',  '_route' => 'avatar_add',);
                }

                // avatar_upload
                if ($pathinfo === '/admin/avatar/upload') {
                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\AvatarController::uploadAction',  '_route' => 'avatar_upload',);
                }

                // avatar_save
                if ($pathinfo === '/admin/avatar/save') {
                    if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                        $allow = array_merge($allow, array('POST', 'PUT'));
                        goto not_avatar_save;
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\AvatarController::saveAction',  '_route' => 'avatar_save',);
                }
                not_avatar_save:

                // avatar_status
                if (preg_match('#^/admin/avatar/(?P<id>[^/]++)/status$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'avatar_status')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\AvatarController::statusAction',));
                }

                // avatar_delete
                if (preg_match('#^/admin/avatar/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'avatar_delete')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\AvatarController::deleteAction',));
                }

            }

            if (0 === strpos($pathinfo, '/admin/contact_question')) {
                // contact_question
                if (rtrim($pathinfo, '/') === '/admin/contact_question') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'contact_question');
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactQuestionController::indexAction',  '_route' => 'contact_question',);
                }

                // contact_question_status
                if (preg_match('#^/admin/contact_question/(?P<id>[^/]++)/contact_question_status$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'contact_question_status')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactQuestionController::statusAction',));
                }

                if (0 === strpos($pathinfo, '/admin/contact_question/new')) {
                    // contact_question_new
                    if ($pathinfo === '/admin/contact_question/new') {
                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactQuestionController::newAction',  '_route' => 'contact_question_new',);
                    }

                    // contact_question_form_create
                    if ($pathinfo === '/admin/contact_question/newcontactquestion_form_create') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_contact_question_form_create;
                        }

                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactQuestionController::createAction',  '_route' => 'contact_question_form_create',);
                    }
                    not_contact_question_form_create:

                }

                // contact_question_edit
                if (preg_match('#^/admin/contact_question/(?P<id>[^/]++)/contact_question_edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'contact_question_edit')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactQuestionController::editAction',));
                }

                // contact_question_update
                if (preg_match('#^/admin/contact_question/(?P<id>[^/]++)/contact_question_update$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'contact_question_update')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactQuestionController::updateAction',));
                }

                // contact_question_delete
                if (preg_match('#^/admin/contact_question/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'contact_question_delete')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactQuestionController::deleteAction',));
                }

                // get_question_category
                if ($pathinfo === '/admin/contact_question/getcategory') {
                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactQuestionController::getcategoryAction',  '_route' => 'get_question_category',);
                }

            }

            if (0 === strpos($pathinfo, '/admin/admin_modules')) {
                // allmodules
                if (rtrim($pathinfo, '/') === '/admin/admin_modules') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'allmodules');
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ModulesController::indexAction',  '_route' => 'allmodules',);
                }

                // modules_status
                if (preg_match('#^/admin/admin_modules/(?P<id>[^/]++)/status$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'modules_status')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ModulesController::statusAction',));
                }

            }

            if (0 === strpos($pathinfo, '/admin/c')) {
                if (0 === strpos($pathinfo, '/admin/contact_category')) {
                    // contact_category
                    if (rtrim($pathinfo, '/') === '/admin/contact_category') {
                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'contact_category');
                        }

                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactCategoryController::indexAction',  '_route' => 'contact_category',);
                    }

                    // contact_category_status
                    if (preg_match('#^/admin/contact_category/(?P<id>[^/]++)/contact_category_status$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'contact_category_status')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactCategoryController::statusAction',));
                    }

                    if (0 === strpos($pathinfo, '/admin/contact_category/new')) {
                        // contact_category_new
                        if ($pathinfo === '/admin/contact_category/new') {
                            return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactCategoryController::newAction',  '_route' => 'contact_category_new',);
                        }

                        // contact_category_form_create
                        if ($pathinfo === '/admin/contact_category/newcontactcategory_form_create') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_contact_category_form_create;
                            }

                            return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactCategoryController::createAction',  '_route' => 'contact_category_form_create',);
                        }
                        not_contact_category_form_create:

                    }

                    // contact_category_edit
                    if (preg_match('#^/admin/contact_category/(?P<id>[^/]++)/contact_category_edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'contact_category_edit')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactCategoryController::editAction',));
                    }

                    // contact_category_update
                    if (preg_match('#^/admin/contact_category/(?P<id>[^/]++)/contact_category_update$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'contact_category_update')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactCategoryController::updateAction',));
                    }

                    // contact_category_delete
                    if (preg_match('#^/admin/contact_category/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'contact_category_delete')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ContactCategoryController::deleteAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/club')) {
                    // club_page_list
                    if (rtrim($pathinfo, '/') === '/admin/club') {
                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'club_page_list');
                        }

                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ClubController::indexAction',  '_route' => 'club_page_list',);
                    }

                    // club_page_add
                    if ($pathinfo === '/admin/club/add') {
                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ClubController::newAction',  '_route' => 'club_page_add',);
                    }

                    // club_page_edit
                    if (preg_match('#^/admin/club/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'club_page_edit')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ClubController::editAction',));
                    }

                    // club_page_update
                    if (preg_match('#^/admin/club/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                            $allow = array_merge($allow, array('POST', 'PUT'));
                            goto not_club_page_update;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'club_page_update')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ClubController::updateAction',));
                    }
                    not_club_page_update:

                    // club_page_status
                    if (preg_match('#^/admin/club/(?P<id>[^/]++)/status$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'club_page_status')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ClubController::statusAction',));
                    }

                    // club_page_form_create
                    if ($pathinfo === '/admin/club/club_page_form_create') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_club_page_form_create;
                        }

                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ClubController::createAction',  '_route' => 'club_page_form_create',);
                    }
                    not_club_page_form_create:

                }

            }

            if (0 === strpos($pathinfo, '/admin/article')) {
                // club_article_list
                if (rtrim($pathinfo, '/') === '/admin/article') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'club_article_list');
                    }

                    return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ArticleController::indexAction',  '_route' => 'club_article_list',);
                }

                // club_article_status
                if (preg_match('#^/admin/article/(?P<id>[^/]++)/status$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'club_article_status')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ArticleController::statusAction',));
                }

                if (0 === strpos($pathinfo, '/admin/article/a')) {
                    // club_article_add
                    if ($pathinfo === '/admin/article/add') {
                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ArticleController::addAction',  '_route' => 'club_article_add',);
                    }

                    // article_page_form_create
                    if ($pathinfo === '/admin/article/article_page_form_create') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_article_page_form_create;
                        }

                        return array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ArticleController::createAction',  '_route' => 'article_page_form_create',);
                    }
                    not_article_page_form_create:

                }

                // article_page_edit
                if (preg_match('#^/admin/article/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'article_page_edit')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ArticleController::editAction',));
                }

                // article_page_update
                if (preg_match('#^/admin/article/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                        $allow = array_merge($allow, array('POST', 'PUT'));
                        goto not_article_page_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'article_page_update')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ArticleController::updateAction',));
                }
                not_article_page_update:

                // article_page_delete
                if (preg_match('#^/admin/article/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'article_page_delete')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ArticleController::deleteAction',));
                }

                // article_page_show
                if (preg_match('#^/admin/article/(?P<id>[^/]++)/details$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'article_page_show')), array (  '_controller' => 'Bundle\\AdminBundle\\Controller\\ArticleController::showAction',));
                }

            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
