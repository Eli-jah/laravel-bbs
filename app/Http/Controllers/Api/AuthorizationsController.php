<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\AuthorizationRequest;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Models\User;
use App\Traits\PassportToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;

class AuthorizationsController extends Controller
{
    use PassportToken;

    public function store(AuthorizationRequest $request, AuthorizationServer $server, ServerRequestInterface $serverRequest)
    {
        // $username = $request->input('username');
        // $username = $request->username;

        // filter_var($username, FILTER_VALIDATE_EMAIL) ? $credentials['email'] = $username : $credentials['phone'] = $username;

        // $credentials['password'] = $request->password;

        // if (!$token = Auth::guard('api')->attempt($credentials)) {
        // // return $this->response->errorUnauthorized('用户名或密码错误');
        // return $this->response->errorUnauthorized(trans('auth.failed'));
        // }

        /*return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ])->setStatusCode(201);*/
        // return $this->respondWithToken($token);

        try {
            return $server->respondToAccessTokenRequest($serverRequest, new Psr7Response)->withStatus(201);
        } catch (OAuthServerException $e) {
            return $this->response->errorUnauthorized($e->getMessage());
        }
    }

    /*public function update()
    {
        $token = Auth::guard('api')->refresh();
        return $this->respondWithToken($token);
    }*/

    public function update(AuthorizationServer $server, ServerRequestInterface $serverRequest)
    {
        try {
            return $server->respondToAccessTokenRequest($serverRequest, new Psr7Response);
        } catch (OAuthServerException $e) {
            return $this->response->errorUnauthorized($e->getMessage());
        }
    }

    /*public function destroy()
    {
        Auth::guard('api')->logout();
        return $this->response->noContent();
    }*/

    public function destroy()
    {
        if (!empty($this->user())) {
            $this->user()->token()->revoke();
            return $this->response->noContent();
        } else {
            return $this->response->errorUnauthorized('The token is invalid.');
        }
    }

    public function socialStore(SocialAuthorizationRequest $request, $social_type)
    {
        if (!in_array($social_type, ['weixin'])) {
            return $this->response->errorBadRequest();
        }

        $driver = Socialite::driver($social_type);

        try {
            if ($code = $request->code) {
                $response = $driver->getAccessTokenResponse($code);
                $token = array_get($response, 'access_token');
            } else {
                $token = $request->access_token;

                if ($social_type == 'weixin') {
                    $driver->setOpenId($request->openid);
                }
            }

            $oauthUser = $driver->userFromToken($token);
        } catch (\Exception $e) {
            return $this->response->errorUnauthorized('参数错误，未获取用户信息');
        }

        switch ($social_type) {
            case 'weixin':
                $unionid = $oauthUser->offsetExists('unionid') ? $oauthUser->offsetGet('unionid') : null;

                if ($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $oauthUser->getId())->first();
                }

                // 没有用户，默认创建一个用户
                if (!$user) {
                    $user = User::create([
                        'name' => $oauthUser->getNickname(),
                        'avatar' => $oauthUser->getAvatar(),
                        'weixin_openid' => $oauthUser->getId(),
                        'weixin_unionid' => $unionid,
                    ]);
                }

                break;
        }

        // return $this->response->array(['token' => $user->id]);
        /*$token = Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token);*/
        $result = $this->getBearerTokenByUser($user, '1', false);
        return $this->response->array($result)->setStatusCode(201);
    }

    protected function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ]);
    }
}
