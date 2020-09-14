<?php
/** register DI */

use SocialNetwork\Application\GetStatisticsAction;
use SocialNetwork\Infrastructure\Repository\HttpUserRepository;
use SocialNetwork\Infrastructure\SlToken\Auth;
use SocialNetwork\Infrastructure\SlToken\SlToken;
use SocialNetwork\Shared\ValueObject\Email;
use SocialNetwork\Shared\ValueObject\Url;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpClient\HttpClient;

$container
    ->register('slToken', SlToken::class)
    ->addArgument(new Auth(
        new Url($_ENV['AUTH_URL']),
        $_ENV['AUTH_CLIENT_ID'],
        new Email($_ENV['AUTH_EMAIL']),
        $_ENV['AUTH_NAME'],
    ))
    ->addArgument(HttpClient::create());

$container
    ->register('httpUserRepository', HttpUserRepository::class)
    ->addArgument(new Url($_ENV['GET_POSTS_URL']))
    ->addArgument($_ENV['TOTAL_PAGES'])
    ->addArgument(new Reference('slToken'))
    ->addArgument(HttpClient::create());

$container
    ->register('getStatisticsAction', GetStatisticsAction::class)
    ->addArgument(new Reference('httpUserRepository'));