<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

use App\Repository\UserRepository;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    protected const API_KEY_FIELD = 'key';

    public function __construct(
        public UserRepository $userRepository
    ){}
    /**
     * @inheritDoc
     */
    public function supports(Request $request): ?bool
    {   
        return true;
    }

    /**
     * @inheritDoc
     */
    public function authenticate(Request $request): Passport
    {
        $apiKey = $request->request->get(self::API_KEY_FIELD);

        if (null === $apiKey) {
            throw new CustomUserMessageAuthenticationException('Auth token not found (field: "key")');
        }

        $apiHash = md5($apiKey);
        $badge = new UserBadge($apiHash, function ($userIdentifier) {
            return $this->userRepository->findOneBy(['api_key' => $userIdentifier]);
        });

        return new SelfValidatingPassport($badge);
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        throw $exception;
    }

    // protected const API_KEY_FIELD = 'key';

    // /**
    //  * @inheritDoc
    //  */
    // public function supports(Request $request): ?bool
    // {   
    //     return $request->request->has(self::API_KEY_FIELD);
    //     //return $request->headers->has(self::HEADER_AUTH_TOKEN);
    // }

    // /**
    //  * @inheritDoc
    //  */
    // public function authenticate(Request $request): Passport
    // {
    //     $apiKey = $request->request->get(self::API_KEY_FIELD);
    //     //$apiToken = $request->headers->get(self::HEADER_AUTH_TOKEN);

    //     if (null === $apiKey) {
    //         throw new CustomUserMessageAuthenticationException('Auth token not found (header: "{{ header }}")', [
    //             '{{ header }}' => self::API_KEY_FIELD,
    //         ]);
    //     }

    //     return new SelfValidatingPassport(new UserBadge($apiKey));
    // }
}