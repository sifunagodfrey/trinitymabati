<?php

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/up' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MYcfnEycWexQyxk4',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.home',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.auth.login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.auth.login.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/verify-2fa' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.auth.verify2fa',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.auth.verify2fa.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/forgot-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.auth.forgot-password',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.auth.forgot-password.send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/forgot-password/verify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.auth.forgot-password.verify',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.auth.forgot-password.verify.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/forgot-password/reset' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.auth.forgot-password.reset',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.auth.forgot-password.reset.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::W6kwUIj4CBakjjCF',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register/verify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'register.verify',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'register.verify.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::a9z4Sae6JVGG57AD',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/forgot-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.request',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/forgot-password/verify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.verify',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.verify.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/forgot-password/reset' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.do-reset',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.do-reset.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login/verify-2fa' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login.verify2fa',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'login.verify2fa.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/verify-email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.notice',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email/verification-notification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/confirm-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.confirm',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ygfM0IZdQb7O2mXd',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.update',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/orders' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.orders.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/review/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.review.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/inbox' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.inbox.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/address' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.address.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/address/set' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.address.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'client.address.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/address/locations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.address.locations',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/wallet' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.wallet.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/wallet/topup' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.wallet.topup',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/wallet/transactions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.wallet.transactions',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/wallet/withdraw' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.wallet.withdraw',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'client.wallet.withdraw.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/wallet/topup/mpesa' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.wallet.topup.mpesa',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/wallet/topup/poll' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.wallet.topup.poll',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/wallet/topup/timeout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.wallet.topup.timeout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/loyalty' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.loyalty.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/loyalty/history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.loyalty.history',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/loyalty/redeem' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.loyalty.redeem',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'client.loyalty.redeem.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/settings/account' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.settings.account',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'client.settings.account.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/settings/account/password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.settings.password.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/settings/payment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.settings.payment',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'client.settings.payment.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/newsletter' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.newsletter.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/newsletter/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.newsletter.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/referrals' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.referrals.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/referrals/generate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.referrals.generate',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/referrals/toggle' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.referrals.toggle',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account/wishlist' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.wishlist.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::IMOZENkoKJ63R1qH',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.dashboard.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/messages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.messages.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/orders' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.orders.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/returns' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.returns.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.returns.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/returns/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.returns.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/returns/order-items' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.returns.order-items',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/invoices' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.invoices.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/reviews' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.reviews.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/customers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.customers.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/flash-sales' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.flash-sales.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/coupons' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.coupons.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.coupons.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/coupons/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.coupons.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/referrals' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.referrals.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/referrals/events' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.referrals.events',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/referrals/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.referrals.settings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.referrals.settings.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/vat-orders' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.vat-orders.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/abandoned-carts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.abandoned-carts.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ecommerce/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.reports.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/products/media-library' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.mediaLibrary',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/products/all' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.all.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/products/all/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.all.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.all.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/products/upload-media' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.uploadMedia',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/products/add/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.add.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.add.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/products/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.categories.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/products/categories/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.categories.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.categories.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/products/brands' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.brands.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/products/brands/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.brands.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.brands.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/products/labels' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.labels.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/products/labels/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.labels.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.labels.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/products/reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.reports.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/quotations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.quotations.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.quotations.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/quotations/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.quotations.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/blogs/posts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.posts.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/blogs/posts/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.posts.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.posts.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/blogs/posts/upload-media' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.posts.uploadMedia',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/blogs/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.categories.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/blogs/categories/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.categories.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.categories.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/blogs/tags' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.tags.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/blogs/tags/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.tags.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/content/pages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.pages.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.pages.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/content/pages/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.pages.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/content/team' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.team.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.team.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/content/team/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.team.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/content/partners' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.partners.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.partners.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/content/partners/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.partners.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/content/faqs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.faqs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.faqs.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/content/faqs/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.faqs.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/payments/transactions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.payments.transactions.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/payments/methods' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.payments.methods.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/payments/logs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.payments.logs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/shipping/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.shipping.settings.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.shipping.settings.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/shipping/pricing' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.shipping.pricing.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.shipping.pricing.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/newsletters' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.newsletters.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/newsletters/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.newsletters.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/media' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.media.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/media/upload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.media.upload',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/seo' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.seo.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.seo.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/seo/metadata' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.seo.metadata',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/branding' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.branding.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.branding.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/vat' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.vat.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.vat.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.email.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.email.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/security' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.security.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.security.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/contact' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.contact.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.contact.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/sms' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.sms.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.sms.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/sms/test' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.sms.test',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/optimization' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.optimization.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/optimization/clear-cache' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.optimization.clear-cache',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/optimization/optimize-assets' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.optimization.optimize-assets',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/settings/optimization/clean-database' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.optimization.clean-database',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/ajax/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ajax.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/visitors-log' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.visitors-log.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/system-users' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.system-users.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.system-users.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/system-users/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.system-users.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/permissions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.permissions.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/permissions/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.permissions.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/manage/contact' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.contact.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/robots.txt' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'seo.robots',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sitemap.xml' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'seo.sitemap',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/about' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.about',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/blog' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.blog',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.categories',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/search/suggestions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.search.suggestions',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.products',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quotation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.quotation.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quotation/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.quotation.search',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quotation/add' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.quotation.add',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quotation/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.quotation.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quotation/remove' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.quotation.remove',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quotation/submit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.quotation.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cart' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.cart',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cart/count' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.cart.count',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cart/add' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.cart.add',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cart/remove' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.cart.remove',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cart/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.cart.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cart/abandon' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.cart.abandon',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payments/mpesa/mpesa_stk_callback_handler' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'mpesa.callback',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payments/paystack/callback' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout.paystack.callback',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payments/paystack/webhook' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout.paystack.webhook',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payments/pesapal/callback' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout.pesapal.callback',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payments/pesapal/ipn' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout.pesapal.ipn',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'POST' => 1,
            'HEAD' => 2,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/checkout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/checkout/locations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout.locations',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/checkout/payment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout.payment',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout.payment.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/checkout/mpesa/polling' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout.mpesa.polling',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/checkout/mpesa/status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout.mpesa.status',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/checkout/mpesa/timeout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout.mpesa.timeout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/testimonials' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.testimonials',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/client-projects' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.projects',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/partners' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.partners',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/our-team' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.team',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/project-gallery' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.project-gallery',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/faq' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.faq',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/contact' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.contact',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.contact.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/track-order' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.track-order',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.track-order.track',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/contact-us' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.contact.us',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/newsletter/subscribe' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.newsletter.subscribe',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/downloads' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.downloads',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account-deletion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.account-deletion',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cookie-policy' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.cookie-policy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/terms-conditions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.terms',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/refund-policy' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.refund-policy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/privacy-policy' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.privacy-policy.public',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/account' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.account',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/favorites' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.favorites',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/brands' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.brands',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/verify\\-email/([^/]++)/([^/]++)(*:39)|/account/(?|orders/([^/]++)(?|(*:76)|/(?|cancel(*:93)|invoice(*:107)))|inbox/([^/]++)(*:131)|wishlist/(?|toggle/([^/]++)(*:166)|remove/([^/]++)(*:189)))|/manage/(?|me(?|ssages/(?|([^/]++)(*:233)|bulk\\-action(*:253)|mark\\-all\\-read(*:276))|dia/(?|([^/]++)(*:300)|refresh(*:315)))|ecommerce/(?|orders/([^/]++)(?|(*:356)|/status(*:371))|re(?|turns/([^/]++)(?|(*:402)|/(?|approve(*:421)|re(?|ject(*:438)|fund(*:450))))|views/([^/]++)(?|(*:478)|/(?|approve(*:497)|reject(*:511))|(*:520))|ferrals/([^/]++)/(?|toggle(*:555)|reward(*:569)))|invoices/([^/]++)(*:596)|c(?|ustomers/([^/]++)(?|(*:628)|/(?|message(*:647)|send\\-message(*:668)|toggle\\-status(*:690)))|oupons/([^/]++)(?|/(?|edit(*:726)|toggle(*:740))|(*:749)))|abandoned\\-carts/([^/]++)(?|(*:787)|/mark\\-recovered(*:811)))|p(?|roducts/(?|all/([^/]++)(?|(*:851)|/(?|edit(?|(*:870))|toggle\\-active(*:893))|(*:902))|reviews/([^/]++)/status(*:934)|categories/([^/]++)(?|/edit(?|(*:972))|(*:981))|brands/([^/]++)(?|/edit(?|(*:1016))|(*:1026))|labels/([^/]++)(?|/edit(?|(*:1062))|(*:1072)))|ayments/(?|transactions/(?|([^/]++)(*:1118)|([0-9]+)/approve(*:1143)|([0-9]+)/reject(*:1167)|([0-9]+)/proof(*:1190))|methods/([^/]++)(?|/(?|edit(*:1227)|toggle(*:1242))|(*:1252))|logs/([^/]++)(*:1275)))|quotations/([^/]++)(?|(*:1308)|/(?|s(?|tatus(*:1330)|end(*:1342))|convert(*:1359))|(*:1369))|blogs/(?|posts/([^/]++)/(?|edit(?|(*:1413))|delete(*:1429)|toggle\\-publish(*:1453))|categories/([^/]++)/(?|edit(?|(*:1493))|delete(*:1509))|tags/([^/]++)/(?|edit(*:1540)|delete(*:1555)))|cont(?|ent/(?|pa(?|ges/([^/]++)(?|/(?|edit(*:1608)|toggle(*:1623))|(*:1633))|rtners/(?|([0-9]+)/edit(*:1666)|([0-9]+)(?|(*:1686))))|client\\-stories/([^/]++)(?|(*:1725)|/(?|create(*:1744)|([^/]++)(?|/edit(*:1769)|(*:1778)))|(*:1789))|team/(?|([0-9]+)/edit(*:1820)|([0-9]+)(?|(*:1840)))|faqs/([^/]++)(?|/(?|edit(*:1875)|toggle(*:1890))|(*:1900)))|act/([^/]++)(?|(*:1926)|/reply(*:1941)))|s(?|hipping/pricing/([^/]++)(*:1980)|ettings/vat/([^/]++)/apply(*:2015)|ystem\\-users/([^/]++)(?|(*:2048)|/edit(*:2062)|(*:2071)))|newsletters/([^/]++)(*:2102))|/s(?|itemaps/(pages|products|categories|projects|blog|content)/([0-9]+)\\.xml(*:2188)|torage/(.*)(?|(*:2211)))|/b(?|log/([^/]++)(*:2239)|rands/([^/]++)(*:2262))|/c(?|ategories/([^/]++)(*:2295)|heckout/payment/([A-Za-z0-9]+)/resubmit(*:2343)|lient\\-projects/([^/]++)(*:2376))|/p(?|roducts/([^/]++)(*:2407)|ages/([^/]++)(*:2429))|/ref/([A-Za-z0-9]+)(*:2458))/?$}sDu',
    ),
    3 => 
    array (
      39 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.verify',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'hash',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      76 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.orders.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      93 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.orders.cancel',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      107 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.orders.invoice',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      131 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.inbox.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      166 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.wishlist.toggle',
          ),
          1 => 
          array (
            0 => 'productId',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      189 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'client.wishlist.remove',
          ),
          1 => 
          array (
            0 => 'productId',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      233 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.messages.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      253 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.messages.bulk-action',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      276 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.messages.mark-all-read',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      300 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.media.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      315 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.media.refresh',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      356 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.orders.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      371 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.orders.update-status',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      402 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.returns.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      421 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.returns.approve',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      438 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.returns.reject',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      450 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.returns.refund',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      478 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.reviews.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      497 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.reviews.approve',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      511 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.reviews.reject',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      520 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.reviews.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      555 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.referrals.toggle',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      569 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.referrals.reward',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      596 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.invoices.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      628 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.customers.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      647 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.customers.message',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      668 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.customers.send-message',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      690 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.customers.toggle-status',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      726 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.coupons.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      740 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.coupons.toggle',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      749 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.coupons.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.coupons.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      787 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.abandoned-carts.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      811 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.ecommerce.abandoned-carts.mark-recovered',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      851 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.all.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      870 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.all.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.all.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      893 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.all.toggle-active',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      902 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.all.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      934 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.reviews.status',
          ),
          1 => 
          array (
            0 => 'reviewId',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      972 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.categories.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.categories.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      981 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.categories.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1016 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.brands.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.brands.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1026 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.brands.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1062 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.labels.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.labels.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1072 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.products.labels.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1118 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.payments.transactions.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1143 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.payments.transactions.approve',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1167 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.payments.transactions.reject',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1190 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.payments.transactions.proof',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1227 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.payments.methods.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1242 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.payments.methods.toggle',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1252 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.payments.methods.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1275 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.payments.logs.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1308 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.quotations.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1330 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.quotations.status',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1342 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.quotations.send',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1359 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.quotations.convert',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1369 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.quotations.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1413 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.posts.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.posts.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1429 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.posts.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1453 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.posts.toggle-publish',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1493 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.categories.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.categories.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1509 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.categories.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1540 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.tags.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1555 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.blogs.tags.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1608 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.pages.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1623 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.pages.toggle',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1633 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.pages.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.pages.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1666 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.partners.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1686 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.partners.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.partners.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1725 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.client-stories.index',
          ),
          1 => 
          array (
            0 => 'kind',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1744 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.client-stories.create',
          ),
          1 => 
          array (
            0 => 'kind',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1769 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.client-stories.edit',
          ),
          1 => 
          array (
            0 => 'kind',
            1 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1778 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.client-stories.update',
          ),
          1 => 
          array (
            0 => 'kind',
            1 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.client-stories.destroy',
          ),
          1 => 
          array (
            0 => 'kind',
            1 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1789 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.client-stories.store',
          ),
          1 => 
          array (
            0 => 'kind',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1820 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.team.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1840 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.team.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.team.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1875 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.faqs.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1890 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.faqs.toggle',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1900 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.faqs.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.content.faqs.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1926 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.contact.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1941 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.contact.reply',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1980 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.shipping.pricing.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2015 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.settings.vat.apply',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2048 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.system-users.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2062 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.system-users.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2071 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.system-users.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'manage.system-users.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2102 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage.newsletters.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2188 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'seo.sitemap.part',
          ),
          1 => 
          array (
            0 => 'type',
            1 => 'page',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2211 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'storage.local',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'storage.local.upload',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2239 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.blog.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2262 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.brands.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2295 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.categories.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2343 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.checkout.payment.resubmit',
          ),
          1 => 
          array (
            0 => 'code',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2376 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.projects.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2407 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.products.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2429 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.pages.show',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2458 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'frontend.referral.visit',
          ),
          1 => 
          array (
            0 => 'code',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'generated::MYcfnEycWexQyxk4' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'up',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:833:"function () {
                    $exception = null;

                    try {
                        \\Illuminate\\Support\\Facades\\Event::dispatch(new \\Illuminate\\Foundation\\Events\\DiagnosingHealth);
                    } catch (\\Throwable $e) {
                        if (app()->hasDebugModeEnabled()) {
                            throw $e;
                        }

                        report($e);

                        $exception = $e->getMessage();
                    }

                    return response(\\Illuminate\\Support\\Facades\\View::file(\'C:\\\\xampp\\\\htdocs\\\\trinitymabati\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Configuration\'.\'/../resources/health-up.blade.php\', [
                        \'exception\' => $exception,
                    ]), status: $exception ? 500 : 200);
                }";s:5:"scope";s:54:"Illuminate\\Foundation\\Configuration\\ApplicationBuilder";s:4:"this";N;s:4:"self";s:32:"00000000000007e60000000000000000";}}',
        'as' => 'generated::MYcfnEycWexQyxk4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\HomeController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\HomeController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.home',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.auth.login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AdminLoginController@showLogin',
        'controller' => 'App\\Http\\Controllers\\Auth\\AdminLoginController@showLogin',
        'as' => 'manage.auth.login',
        'namespace' => NULL,
        'prefix' => '/manage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.auth.login.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AdminLoginController@login',
        'controller' => 'App\\Http\\Controllers\\Auth\\AdminLoginController@login',
        'as' => 'manage.auth.login.submit',
        'namespace' => NULL,
        'prefix' => '/manage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.auth.verify2fa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/verify-2fa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AdminLoginController@showVerify',
        'controller' => 'App\\Http\\Controllers\\Auth\\AdminLoginController@showVerify',
        'as' => 'manage.auth.verify2fa',
        'namespace' => NULL,
        'prefix' => '/manage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.auth.verify2fa.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/verify-2fa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AdminLoginController@verify',
        'controller' => 'App\\Http\\Controllers\\Auth\\AdminLoginController@verify',
        'as' => 'manage.auth.verify2fa.submit',
        'namespace' => NULL,
        'prefix' => '/manage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.auth.forgot-password' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Auth\\ManageForgotPasswordController@showRequest',
        'controller' => 'App\\Http\\Controllers\\Manage\\Auth\\ManageForgotPasswordController@showRequest',
        'as' => 'manage.auth.forgot-password',
        'namespace' => NULL,
        'prefix' => '/manage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.auth.forgot-password.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Auth\\ManageForgotPasswordController@sendCode',
        'controller' => 'App\\Http\\Controllers\\Manage\\Auth\\ManageForgotPasswordController@sendCode',
        'as' => 'manage.auth.forgot-password.send',
        'namespace' => NULL,
        'prefix' => '/manage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.auth.forgot-password.verify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/forgot-password/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Auth\\ManageForgotPasswordController@showVerify',
        'controller' => 'App\\Http\\Controllers\\Manage\\Auth\\ManageForgotPasswordController@showVerify',
        'as' => 'manage.auth.forgot-password.verify',
        'namespace' => NULL,
        'prefix' => '/manage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.auth.forgot-password.verify.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/forgot-password/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Auth\\ManageForgotPasswordController@verifyCode',
        'controller' => 'App\\Http\\Controllers\\Manage\\Auth\\ManageForgotPasswordController@verifyCode',
        'as' => 'manage.auth.forgot-password.verify.submit',
        'namespace' => NULL,
        'prefix' => '/manage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.auth.forgot-password.reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/forgot-password/reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Auth\\ManageForgotPasswordController@showReset',
        'controller' => 'App\\Http\\Controllers\\Manage\\Auth\\ManageForgotPasswordController@showReset',
        'as' => 'manage.auth.forgot-password.reset',
        'namespace' => NULL,
        'prefix' => '/manage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.auth.forgot-password.reset.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/forgot-password/reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Auth\\ManageForgotPasswordController@resetPassword',
        'controller' => 'App\\Http\\Controllers\\Manage\\Auth\\ManageForgotPasswordController@resetPassword',
        'as' => 'manage.auth.forgot-password.reset.submit',
        'namespace' => NULL,
        'prefix' => '/manage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisteredUserController@create',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisteredUserController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::W6kwUIj4CBakjjCF' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisteredUserController@store',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisteredUserController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::W6kwUIj4CBakjjCF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register.verify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'register/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisteredUserController@showVerify',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisteredUserController@showVerify',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register.verify',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register.verify.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'register/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisteredUserController@verify',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisteredUserController@verify',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register.verify.submit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@create',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::a9z4Sae6JVGG57AD' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@store',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::a9z4Sae6JVGG57AD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.request' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showRequest',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showRequest',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.request',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@sendCode',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@sendCode',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.verify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'forgot-password/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showVerify',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showVerify',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.verify',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.verify.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'forgot-password/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@verifyCode',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@verifyCode',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.verify.submit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.do-reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'forgot-password/reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showReset',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showReset',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.do-reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.do-reset.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'forgot-password/reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
          2 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@resetPassword',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@resetPassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.do-reset.submit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login.verify2fa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login/verify-2fa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@showVerify',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@showVerify',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login.verify2fa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login.verify2fa.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login/verify-2fa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@verify',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@verify',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login.verify2fa.submit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.notice' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'verify-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\EmailVerificationPromptController@__invoke',
        'controller' => 'App\\Http\\Controllers\\Auth\\EmailVerificationPromptController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.notice',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.verify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'verify-email/{id}/{hash}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'signed',
          3 => 'throttle:6,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\VerifyEmailController@__invoke',
        'controller' => 'App\\Http\\Controllers\\Auth\\VerifyEmailController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.verify',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'email/verification-notification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\EmailVerificationNotificationController@store',
        'controller' => 'App\\Http\\Controllers\\Auth\\EmailVerificationNotificationController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.send',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.confirm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'confirm-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ConfirmablePasswordController@show',
        'controller' => 'App\\Http\\Controllers\\Auth\\ConfirmablePasswordController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.confirm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ygfM0IZdQb7O2mXd' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'confirm-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'throttle:storefront-auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ConfirmablePasswordController@store',
        'controller' => 'App\\Http\\Controllers\\Auth\\ConfirmablePasswordController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ygfM0IZdQb7O2mXd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\PasswordController@update',
        'controller' => 'App\\Http\\Controllers\\Auth\\PasswordController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@destroy',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\DashboardController@index',
        'controller' => 'App\\Http\\Controllers\\Client\\DashboardController@index',
        'as' => 'client.dashboard',
        'namespace' => NULL,
        'prefix' => '/account',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.orders.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/orders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\OrderController@index',
        'controller' => 'App\\Http\\Controllers\\Client\\OrderController@index',
        'as' => 'client.orders.index',
        'namespace' => NULL,
        'prefix' => 'account/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.orders.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/orders/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\OrderController@show',
        'controller' => 'App\\Http\\Controllers\\Client\\OrderController@show',
        'as' => 'client.orders.show',
        'namespace' => NULL,
        'prefix' => 'account/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.orders.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/orders/{id}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\OrderController@cancel',
        'controller' => 'App\\Http\\Controllers\\Client\\OrderController@cancel',
        'as' => 'client.orders.cancel',
        'namespace' => NULL,
        'prefix' => 'account/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.orders.invoice' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/orders/{id}/invoice',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\OrderController@invoice',
        'controller' => 'App\\Http\\Controllers\\Client\\OrderController@invoice',
        'as' => 'client.orders.invoice',
        'namespace' => NULL,
        'prefix' => 'account/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.review.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/review/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\ProductReviewController@store',
        'controller' => 'App\\Http\\Controllers\\Client\\ProductReviewController@store',
        'as' => 'client.review.store',
        'namespace' => NULL,
        'prefix' => '/account',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.inbox.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/inbox',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\InboxController@index',
        'controller' => 'App\\Http\\Controllers\\Client\\InboxController@index',
        'as' => 'client.inbox.index',
        'namespace' => NULL,
        'prefix' => 'account/inbox',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.inbox.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/inbox/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\InboxController@show',
        'controller' => 'App\\Http\\Controllers\\Client\\InboxController@show',
        'as' => 'client.inbox.show',
        'namespace' => NULL,
        'prefix' => 'account/inbox',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.address.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/address',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\AddressController@index',
        'controller' => 'App\\Http\\Controllers\\Client\\AddressController@index',
        'as' => 'client.address.index',
        'namespace' => NULL,
        'prefix' => 'account/address',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.address.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/address/set',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\AddressController@create',
        'controller' => 'App\\Http\\Controllers\\Client\\AddressController@create',
        'as' => 'client.address.create',
        'namespace' => NULL,
        'prefix' => 'account/address',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.address.locations' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/address/locations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\AddressController@locations',
        'controller' => 'App\\Http\\Controllers\\Client\\AddressController@locations',
        'as' => 'client.address.locations',
        'namespace' => NULL,
        'prefix' => 'account/address',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.address.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/address/set',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\AddressController@store',
        'controller' => 'App\\Http\\Controllers\\Client\\AddressController@store',
        'as' => 'client.address.store',
        'namespace' => NULL,
        'prefix' => 'account/address',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.wallet.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/wallet',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\WalletController@index',
        'controller' => 'App\\Http\\Controllers\\Client\\WalletController@index',
        'as' => 'client.wallet.index',
        'namespace' => NULL,
        'prefix' => 'account/wallet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.wallet.topup' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/wallet/topup',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\WalletController@topup',
        'controller' => 'App\\Http\\Controllers\\Client\\WalletController@topup',
        'as' => 'client.wallet.topup',
        'namespace' => NULL,
        'prefix' => 'account/wallet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.wallet.transactions' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/wallet/transactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\WalletController@transactions',
        'controller' => 'App\\Http\\Controllers\\Client\\WalletController@transactions',
        'as' => 'client.wallet.transactions',
        'namespace' => NULL,
        'prefix' => 'account/wallet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.wallet.withdraw' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/wallet/withdraw',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\WalletController@withdraw',
        'controller' => 'App\\Http\\Controllers\\Client\\WalletController@withdraw',
        'as' => 'client.wallet.withdraw',
        'namespace' => NULL,
        'prefix' => 'account/wallet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.wallet.withdraw.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/wallet/withdraw',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\WalletController@processWithdraw',
        'controller' => 'App\\Http\\Controllers\\Client\\WalletController@processWithdraw',
        'as' => 'client.wallet.withdraw.store',
        'namespace' => NULL,
        'prefix' => 'account/wallet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.wallet.topup.mpesa' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/wallet/topup/mpesa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\WalletController@initiateTopupMpesa',
        'controller' => 'App\\Http\\Controllers\\Client\\WalletController@initiateTopupMpesa',
        'as' => 'client.wallet.topup.mpesa',
        'namespace' => NULL,
        'prefix' => 'account/wallet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.wallet.topup.poll' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/wallet/topup/poll',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\WalletController@pollTopupStatus',
        'controller' => 'App\\Http\\Controllers\\Client\\WalletController@pollTopupStatus',
        'as' => 'client.wallet.topup.poll',
        'namespace' => NULL,
        'prefix' => 'account/wallet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.wallet.topup.timeout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/wallet/topup/timeout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\WalletController@reportTopupTimeout',
        'controller' => 'App\\Http\\Controllers\\Client\\WalletController@reportTopupTimeout',
        'as' => 'client.wallet.topup.timeout',
        'namespace' => NULL,
        'prefix' => 'account/wallet',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.loyalty.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/loyalty',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\LoyaltyController@index',
        'controller' => 'App\\Http\\Controllers\\Client\\LoyaltyController@index',
        'as' => 'client.loyalty.index',
        'namespace' => NULL,
        'prefix' => 'account/loyalty',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.loyalty.history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/loyalty/history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\LoyaltyController@history',
        'controller' => 'App\\Http\\Controllers\\Client\\LoyaltyController@history',
        'as' => 'client.loyalty.history',
        'namespace' => NULL,
        'prefix' => 'account/loyalty',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.loyalty.redeem' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/loyalty/redeem',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\LoyaltyController@showRedeem',
        'controller' => 'App\\Http\\Controllers\\Client\\LoyaltyController@showRedeem',
        'as' => 'client.loyalty.redeem',
        'namespace' => NULL,
        'prefix' => 'account/loyalty',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.loyalty.redeem.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/loyalty/redeem',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:125:"fn () => \\redirect()->route(\'client.loyalty.index\')
                ->with(\'info\', \'Redemption will be applied at checkout.\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000008330000000000000000";}}',
        'as' => 'client.loyalty.redeem.store',
        'namespace' => NULL,
        'prefix' => 'account/loyalty',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.settings.account' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/settings/account',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\AccountSettingsController@edit',
        'controller' => 'App\\Http\\Controllers\\Client\\AccountSettingsController@edit',
        'as' => 'client.settings.account',
        'namespace' => NULL,
        'prefix' => 'account/settings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.settings.account.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/settings/account',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\AccountSettingsController@updateProfile',
        'controller' => 'App\\Http\\Controllers\\Client\\AccountSettingsController@updateProfile',
        'as' => 'client.settings.account.update',
        'namespace' => NULL,
        'prefix' => 'account/settings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.settings.password.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/settings/account/password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\AccountSettingsController@updatePassword',
        'controller' => 'App\\Http\\Controllers\\Client\\AccountSettingsController@updatePassword',
        'as' => 'client.settings.password.update',
        'namespace' => NULL,
        'prefix' => 'account/settings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.settings.payment' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/settings/payment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\PaymentSettingsController@edit',
        'controller' => 'App\\Http\\Controllers\\Client\\PaymentSettingsController@edit',
        'as' => 'client.settings.payment',
        'namespace' => NULL,
        'prefix' => '/account',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.settings.payment.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/settings/payment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\PaymentSettingsController@update',
        'controller' => 'App\\Http\\Controllers\\Client\\PaymentSettingsController@update',
        'as' => 'client.settings.payment.update',
        'namespace' => NULL,
        'prefix' => '/account',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.newsletter.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/newsletter',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\NewsletterController@index',
        'controller' => 'App\\Http\\Controllers\\Client\\NewsletterController@index',
        'as' => 'client.newsletter.index',
        'namespace' => NULL,
        'prefix' => 'account/newsletter',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.newsletter.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/newsletter/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\NewsletterController@update',
        'controller' => 'App\\Http\\Controllers\\Client\\NewsletterController@update',
        'as' => 'client.newsletter.update',
        'namespace' => NULL,
        'prefix' => 'account/newsletter',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.referrals.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/referrals',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\ReferralController@index',
        'controller' => 'App\\Http\\Controllers\\Client\\ReferralController@index',
        'as' => 'client.referrals.index',
        'namespace' => NULL,
        'prefix' => 'account/referrals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.referrals.generate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/referrals/generate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\ReferralController@generate',
        'controller' => 'App\\Http\\Controllers\\Client\\ReferralController@generate',
        'as' => 'client.referrals.generate',
        'namespace' => NULL,
        'prefix' => 'account/referrals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.referrals.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/referrals/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\ReferralController@toggle',
        'controller' => 'App\\Http\\Controllers\\Client\\ReferralController@toggle',
        'as' => 'client.referrals.toggle',
        'namespace' => NULL,
        'prefix' => 'account/referrals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.wishlist.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account/wishlist',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\WishlistController@index',
        'controller' => 'App\\Http\\Controllers\\Client\\WishlistController@index',
        'as' => 'client.wishlist.index',
        'namespace' => NULL,
        'prefix' => 'account/wishlist',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.wishlist.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/wishlist/toggle/{productId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\WishlistController@toggle',
        'controller' => 'App\\Http\\Controllers\\Client\\WishlistController@toggle',
        'as' => 'client.wishlist.toggle',
        'namespace' => NULL,
        'prefix' => 'account/wishlist',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'client.wishlist.remove' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'account/wishlist/remove/{productId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,customer',
          3 => 'remember.session',
        ),
        'uses' => 'App\\Http\\Controllers\\Client\\WishlistController@remove',
        'controller' => 'App\\Http\\Controllers\\Client\\WishlistController@remove',
        'as' => 'client.wishlist.remove',
        'namespace' => NULL,
        'prefix' => 'account/wishlist',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::IMOZENkoKJ63R1qH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:227:"function () {
            if (\\Illuminate\\Support\\Facades\\Auth::check()) {
                return \\redirect()->route(\'manage.dashboard.index\');
            }
            return \\redirect()->route(\'manage.auth.login\');
        }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000008110000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '/manage',
        'where' => 
        array (
        ),
        'as' => 'generated::IMOZENkoKJ63R1qH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.dashboard.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\DashboardController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\DashboardController@index',
        'as' => 'manage.dashboard.index',
        'namespace' => NULL,
        'prefix' => 'manage/dashboard',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.messages.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:send_notifications',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\MessagesController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\MessagesController@index',
        'as' => 'manage.messages.index',
        'namespace' => NULL,
        'prefix' => 'manage/messages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.messages.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/messages/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:send_notifications',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\MessagesController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\MessagesController@show',
        'as' => 'manage.messages.show',
        'namespace' => NULL,
        'prefix' => 'manage/messages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.messages.bulk-action' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/messages/bulk-action',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:send_notifications',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\MessagesController@bulkAction',
        'controller' => 'App\\Http\\Controllers\\Manage\\MessagesController@bulkAction',
        'as' => 'manage.messages.bulk-action',
        'namespace' => NULL,
        'prefix' => 'manage/messages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.messages.mark-all-read' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/messages/mark-all-read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:send_notifications',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\MessagesController@markAllRead',
        'controller' => 'App\\Http\\Controllers\\Manage\\MessagesController@markAllRead',
        'as' => 'manage.messages.mark-all-read',
        'namespace' => NULL,
        'prefix' => 'manage/messages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.orders.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/orders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\OrdersController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\OrdersController@index',
        'as' => 'manage.ecommerce.orders.index',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.orders.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/orders/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\OrdersController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\OrdersController@show',
        'as' => 'manage.ecommerce.orders.show',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.orders.update-status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/orders/{id}/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\OrdersController@updateStatus',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\OrdersController@updateStatus',
        'as' => 'manage.ecommerce.orders.update-status',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.returns.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/returns',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@index',
        'as' => 'manage.ecommerce.returns.index',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.returns.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/returns/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@create',
        'as' => 'manage.ecommerce.returns.create',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.returns.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/returns',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@store',
        'as' => 'manage.ecommerce.returns.store',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.returns.order-items' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/returns/order-items',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@orderItems',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@orderItems',
        'as' => 'manage.ecommerce.returns.order-items',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.returns.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/returns/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@show',
        'as' => 'manage.ecommerce.returns.show',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.returns.approve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/returns/{id}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@approve',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@approve',
        'as' => 'manage.ecommerce.returns.approve',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.returns.reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/returns/{id}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@reject',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@reject',
        'as' => 'manage.ecommerce.returns.reject',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.returns.refund' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/returns/{id}/refund',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@refund',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReturnsController@refund',
        'as' => 'manage.ecommerce.returns.refund',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/returns',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.invoices.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/invoices',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\InvoicesController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\InvoicesController@index',
        'as' => 'manage.ecommerce.invoices.index',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.invoices.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/invoices/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\InvoicesController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\InvoicesController@show',
        'as' => 'manage.ecommerce.invoices.show',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.reviews.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/reviews',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReviewsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReviewsController@index',
        'as' => 'manage.ecommerce.reviews.index',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/reviews',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.reviews.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/reviews/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReviewsController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReviewsController@show',
        'as' => 'manage.ecommerce.reviews.show',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/reviews',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.reviews.approve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/reviews/{id}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReviewsController@approve',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReviewsController@approve',
        'as' => 'manage.ecommerce.reviews.approve',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/reviews',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.reviews.reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/reviews/{id}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReviewsController@reject',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReviewsController@reject',
        'as' => 'manage.ecommerce.reviews.reject',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/reviews',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.reviews.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/ecommerce/reviews/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReviewsController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReviewsController@destroy',
        'as' => 'manage.ecommerce.reviews.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/reviews',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.customers.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/customers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CustomersController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CustomersController@index',
        'as' => 'manage.ecommerce.customers.index',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/customers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.customers.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/customers/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CustomersController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CustomersController@show',
        'as' => 'manage.ecommerce.customers.show',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/customers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.customers.message' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/customers/{id}/message',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CustomersController@message',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CustomersController@message',
        'as' => 'manage.ecommerce.customers.message',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/customers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.customers.send-message' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/customers/{id}/send-message',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CustomersController@sendMessage',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CustomersController@sendMessage',
        'as' => 'manage.ecommerce.customers.send-message',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/customers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.customers.toggle-status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/customers/{id}/toggle-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CustomersController@toggleStatus',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CustomersController@toggleStatus',
        'as' => 'manage.ecommerce.customers.toggle-status',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/customers',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.flash-sales.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/flash-sales',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\FlashSalesController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\FlashSalesController@index',
        'as' => 'manage.ecommerce.flash-sales.index',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/flash-sales',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.coupons.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/coupons',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@index',
        'as' => 'manage.ecommerce.coupons.index',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/coupons',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.coupons.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/coupons/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@create',
        'as' => 'manage.ecommerce.coupons.create',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/coupons',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.coupons.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/coupons',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@store',
        'as' => 'manage.ecommerce.coupons.store',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/coupons',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.coupons.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/coupons/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@edit',
        'as' => 'manage.ecommerce.coupons.edit',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/coupons',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.coupons.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'manage/ecommerce/coupons/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@update',
        'as' => 'manage.ecommerce.coupons.update',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/coupons',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.coupons.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/coupons/{id}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@toggleStatus',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@toggleStatus',
        'as' => 'manage.ecommerce.coupons.toggle',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/coupons',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.coupons.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/ecommerce/coupons/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\CouponsController@destroy',
        'as' => 'manage.ecommerce.coupons.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/coupons',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.referrals.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/referrals',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReferralsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReferralsController@index',
        'as' => 'manage.ecommerce.referrals.index',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/referrals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.referrals.events' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/referrals/events',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReferralsController@events',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReferralsController@events',
        'as' => 'manage.ecommerce.referrals.events',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/referrals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.referrals.settings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/referrals/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReferralsController@settings',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReferralsController@settings',
        'as' => 'manage.ecommerce.referrals.settings',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/referrals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.referrals.settings.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/referrals/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReferralsController@updateSettings',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReferralsController@updateSettings',
        'as' => 'manage.ecommerce.referrals.settings.update',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/referrals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.referrals.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/referrals/{id}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReferralsController@toggle',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReferralsController@toggle',
        'as' => 'manage.ecommerce.referrals.toggle',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/referrals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.referrals.reward' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/referrals/{id}/reward',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReferralsController@markRewarded',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReferralsController@markRewarded',
        'as' => 'manage.ecommerce.referrals.reward',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/referrals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.vat-orders.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/vat-orders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\VatOrdersController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\VatOrdersController@index',
        'as' => 'manage.ecommerce.vat-orders.index',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/vat-orders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.abandoned-carts.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/abandoned-carts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\AbandonedCartsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\AbandonedCartsController@index',
        'as' => 'manage.ecommerce.abandoned-carts.index',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/abandoned-carts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.abandoned-carts.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/abandoned-carts/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\AbandonedCartsController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\AbandonedCartsController@show',
        'as' => 'manage.ecommerce.abandoned-carts.show',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/abandoned-carts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.abandoned-carts.mark-recovered' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/ecommerce/abandoned-carts/{id}/mark-recovered',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\AbandonedCartsController@markRecovered',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\AbandonedCartsController@markRecovered',
        'as' => 'manage.ecommerce.abandoned-carts.mark-recovered',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/abandoned-carts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ecommerce.reports.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ecommerce/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReportsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Ecommerce\\ReportsController@index',
        'as' => 'manage.ecommerce.reports.index',
        'namespace' => NULL,
        'prefix' => 'manage/ecommerce/reports',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.mediaLibrary' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/media-library',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@mediaLibrary',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@mediaLibrary',
        'as' => 'manage.products.mediaLibrary',
        'namespace' => NULL,
        'prefix' => 'manage/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.all.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/all',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@index',
        'as' => 'manage.products.all.index',
        'namespace' => NULL,
        'prefix' => 'manage/products/all',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.all.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/all/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@create',
        'as' => 'manage.products.all.create',
        'namespace' => NULL,
        'prefix' => 'manage/products/all',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.all.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/products/all/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@store',
        'as' => 'manage.products.all.store',
        'namespace' => NULL,
        'prefix' => 'manage/products/all',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.all.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/all/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@show',
        'as' => 'manage.products.all.show',
        'namespace' => NULL,
        'prefix' => 'manage/products/all',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.all.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/all/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@edit',
        'as' => 'manage.products.all.edit',
        'namespace' => NULL,
        'prefix' => 'manage/products/all',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.all.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'manage/products/all/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@update',
        'as' => 'manage.products.all.update',
        'namespace' => NULL,
        'prefix' => 'manage/products/all',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.all.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/products/all/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@destroy',
        'as' => 'manage.products.all.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/products/all',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.all.toggle-active' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/products/all/{id}/toggle-active',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@toggleActive',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@toggleActive',
        'as' => 'manage.products.all.toggle-active',
        'namespace' => NULL,
        'prefix' => 'manage/products/all',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.reviews.status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/products/reviews/{reviewId}/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@updateReviewStatus',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@updateReviewStatus',
        'as' => 'manage.products.reviews.status',
        'namespace' => NULL,
        'prefix' => 'manage/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.uploadMedia' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/products/upload-media',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@uploadMedia',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@uploadMedia',
        'as' => 'manage.products.uploadMedia',
        'namespace' => NULL,
        'prefix' => 'manage/products',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.add.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/add/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@create',
        'as' => 'manage.products.add.create',
        'namespace' => NULL,
        'prefix' => 'manage/products/add',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.add.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/products/add/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ProductsController@store',
        'as' => 'manage.products.add.store',
        'namespace' => NULL,
        'prefix' => 'manage/products/add',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.categories.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\CategoriesController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\CategoriesController@index',
        'as' => 'manage.products.categories.index',
        'namespace' => NULL,
        'prefix' => 'manage/products/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.categories.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/categories/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\CategoriesController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\CategoriesController@create',
        'as' => 'manage.products.categories.create',
        'namespace' => NULL,
        'prefix' => 'manage/products/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.categories.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/products/categories/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\CategoriesController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\CategoriesController@store',
        'as' => 'manage.products.categories.store',
        'namespace' => NULL,
        'prefix' => 'manage/products/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.categories.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/categories/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\CategoriesController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\CategoriesController@edit',
        'as' => 'manage.products.categories.edit',
        'namespace' => NULL,
        'prefix' => 'manage/products/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.categories.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/products/categories/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\CategoriesController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\CategoriesController@update',
        'as' => 'manage.products.categories.update',
        'namespace' => NULL,
        'prefix' => 'manage/products/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.categories.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/products/categories/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\CategoriesController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\CategoriesController@destroy',
        'as' => 'manage.products.categories.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/products/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.brands.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/brands',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\BrandsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\BrandsController@index',
        'as' => 'manage.products.brands.index',
        'namespace' => NULL,
        'prefix' => 'manage/products/brands',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.brands.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/brands/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\BrandsController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\BrandsController@create',
        'as' => 'manage.products.brands.create',
        'namespace' => NULL,
        'prefix' => 'manage/products/brands',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.brands.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/products/brands/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\BrandsController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\BrandsController@store',
        'as' => 'manage.products.brands.store',
        'namespace' => NULL,
        'prefix' => 'manage/products/brands',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.brands.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/brands/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\BrandsController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\BrandsController@edit',
        'as' => 'manage.products.brands.edit',
        'namespace' => NULL,
        'prefix' => 'manage/products/brands',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.brands.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/products/brands/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\BrandsController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\BrandsController@update',
        'as' => 'manage.products.brands.update',
        'namespace' => NULL,
        'prefix' => 'manage/products/brands',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.brands.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/products/brands/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\BrandsController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\BrandsController@destroy',
        'as' => 'manage.products.brands.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/products/brands',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.labels.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/labels',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\LabelsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\LabelsController@index',
        'as' => 'manage.products.labels.index',
        'namespace' => NULL,
        'prefix' => 'manage/products/labels',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.labels.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/labels/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\LabelsController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\LabelsController@create',
        'as' => 'manage.products.labels.create',
        'namespace' => NULL,
        'prefix' => 'manage/products/labels',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.labels.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/products/labels/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\LabelsController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\LabelsController@store',
        'as' => 'manage.products.labels.store',
        'namespace' => NULL,
        'prefix' => 'manage/products/labels',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.labels.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/labels/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\LabelsController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\LabelsController@edit',
        'as' => 'manage.products.labels.edit',
        'namespace' => NULL,
        'prefix' => 'manage/products/labels',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.labels.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/products/labels/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\LabelsController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\LabelsController@update',
        'as' => 'manage.products.labels.update',
        'namespace' => NULL,
        'prefix' => 'manage/products/labels',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.labels.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/products/labels/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\LabelsController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\LabelsController@destroy',
        'as' => 'manage.products.labels.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/products/labels',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.products.reports.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/products/reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_products',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Products\\ReportsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Products\\ReportsController@index',
        'as' => 'manage.products.reports.index',
        'namespace' => NULL,
        'prefix' => 'manage/products/reports',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.quotations.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/quotations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_quotations|view_quotations',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@index',
        'as' => 'manage.quotations.index',
        'namespace' => NULL,
        'prefix' => 'manage/quotations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.quotations.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/quotations/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_quotations|view_quotations',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@create',
        'as' => 'manage.quotations.create',
        'namespace' => NULL,
        'prefix' => 'manage/quotations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.quotations.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/quotations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_quotations|view_quotations',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@store',
        'as' => 'manage.quotations.store',
        'namespace' => NULL,
        'prefix' => 'manage/quotations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.quotations.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/quotations/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_quotations|view_quotations',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@show',
        'as' => 'manage.quotations.show',
        'namespace' => NULL,
        'prefix' => 'manage/quotations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.quotations.status' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'manage/quotations/{id}/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_quotations|view_quotations',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@updateStatus',
        'controller' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@updateStatus',
        'as' => 'manage.quotations.status',
        'namespace' => NULL,
        'prefix' => 'manage/quotations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.quotations.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/quotations/{id}/send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_quotations|view_quotations',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@send',
        'controller' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@send',
        'as' => 'manage.quotations.send',
        'namespace' => NULL,
        'prefix' => 'manage/quotations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.quotations.convert' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/quotations/{id}/convert',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_quotations|view_quotations',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@convert',
        'controller' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@convert',
        'as' => 'manage.quotations.convert',
        'namespace' => NULL,
        'prefix' => 'manage/quotations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.quotations.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/quotations/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_quotations|view_quotations',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Quotations\\QuotationsController@destroy',
        'as' => 'manage.quotations.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/quotations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.posts.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/blogs/posts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@index',
        'as' => 'manage.blogs.posts.index',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.posts.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/blogs/posts/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@create',
        'as' => 'manage.blogs.posts.create',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.posts.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/blogs/posts/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@store',
        'as' => 'manage.blogs.posts.store',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.posts.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/blogs/posts/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@edit',
        'as' => 'manage.blogs.posts.edit',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.posts.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/blogs/posts/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@update',
        'as' => 'manage.blogs.posts.update',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.posts.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/blogs/posts/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@destroy',
        'as' => 'manage.blogs.posts.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.posts.toggle-publish' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/blogs/posts/{id}/toggle-publish',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@togglePublish',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@togglePublish',
        'as' => 'manage.blogs.posts.toggle-publish',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.posts.uploadMedia' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/blogs/posts/upload-media',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@uploadMedia',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\PostsController@uploadMedia',
        'as' => 'manage.blogs.posts.uploadMedia',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.categories.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/blogs/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\CategoriesController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\CategoriesController@index',
        'as' => 'manage.blogs.categories.index',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.categories.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/blogs/categories/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\CategoriesController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\CategoriesController@create',
        'as' => 'manage.blogs.categories.create',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.categories.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/blogs/categories/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\CategoriesController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\CategoriesController@store',
        'as' => 'manage.blogs.categories.store',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.categories.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/blogs/categories/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\CategoriesController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\CategoriesController@edit',
        'as' => 'manage.blogs.categories.edit',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.categories.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/blogs/categories/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\CategoriesController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\CategoriesController@update',
        'as' => 'manage.blogs.categories.update',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.categories.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/blogs/categories/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\CategoriesController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\CategoriesController@destroy',
        'as' => 'manage.blogs.categories.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/categories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.tags.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/blogs/tags',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\TagsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\TagsController@index',
        'as' => 'manage.blogs.tags.index',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/tags',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.tags.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/blogs/tags/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\TagsController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\TagsController@store',
        'as' => 'manage.blogs.tags.store',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/tags',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.tags.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/blogs/tags/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\TagsController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\TagsController@update',
        'as' => 'manage.blogs.tags.update',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/tags',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.blogs.tags.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/blogs/tags/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_blog',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Blogs\\TagsController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Blogs\\TagsController@destroy',
        'as' => 'manage.blogs.tags.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/blogs/tags',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.pages.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/pages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@index',
        'as' => 'manage.content.pages.index',
        'namespace' => NULL,
        'prefix' => 'manage/content/pages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.pages.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/pages/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@create',
        'as' => 'manage.content.pages.create',
        'namespace' => NULL,
        'prefix' => 'manage/content/pages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.pages.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/content/pages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@store',
        'as' => 'manage.content.pages.store',
        'namespace' => NULL,
        'prefix' => 'manage/content/pages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.pages.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/pages/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@edit',
        'as' => 'manage.content.pages.edit',
        'namespace' => NULL,
        'prefix' => 'manage/content/pages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.pages.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'manage/content/pages/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@update',
        'as' => 'manage.content.pages.update',
        'namespace' => NULL,
        'prefix' => 'manage/content/pages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.pages.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/content/pages/{id}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@toggle',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@toggle',
        'as' => 'manage.content.pages.toggle',
        'namespace' => NULL,
        'prefix' => 'manage/content/pages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.pages.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/content/pages/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PagesController@destroy',
        'as' => 'manage.content.pages.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/content/pages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.client-stories.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/client-stories/{kind}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\ClientStoriesController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\ClientStoriesController@index',
        'as' => 'manage.content.client-stories.index',
        'namespace' => NULL,
        'prefix' => 'manage/content/client-stories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.client-stories.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/client-stories/{kind}/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\ClientStoriesController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\ClientStoriesController@create',
        'as' => 'manage.content.client-stories.create',
        'namespace' => NULL,
        'prefix' => 'manage/content/client-stories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.client-stories.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/content/client-stories/{kind}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\ClientStoriesController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\ClientStoriesController@store',
        'as' => 'manage.content.client-stories.store',
        'namespace' => NULL,
        'prefix' => 'manage/content/client-stories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.client-stories.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/client-stories/{kind}/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\ClientStoriesController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\ClientStoriesController@edit',
        'as' => 'manage.content.client-stories.edit',
        'namespace' => NULL,
        'prefix' => 'manage/content/client-stories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.client-stories.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'manage/content/client-stories/{kind}/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\ClientStoriesController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\ClientStoriesController@update',
        'as' => 'manage.content.client-stories.update',
        'namespace' => NULL,
        'prefix' => 'manage/content/client-stories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.client-stories.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/content/client-stories/{kind}/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\ClientStoriesController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\ClientStoriesController@destroy',
        'as' => 'manage.content.client-stories.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/content/client-stories',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.team.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/team',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\TeamMembersController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\TeamMembersController@index',
        'as' => 'manage.content.team.index',
        'namespace' => NULL,
        'prefix' => 'manage/content/team',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.team.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/team/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\TeamMembersController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\TeamMembersController@create',
        'as' => 'manage.content.team.create',
        'namespace' => NULL,
        'prefix' => 'manage/content/team',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.team.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/content/team',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\TeamMembersController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\TeamMembersController@store',
        'as' => 'manage.content.team.store',
        'namespace' => NULL,
        'prefix' => 'manage/content/team',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.team.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/team/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\TeamMembersController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\TeamMembersController@edit',
        'as' => 'manage.content.team.edit',
        'namespace' => NULL,
        'prefix' => 'manage/content/team',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'id' => '[0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.team.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'manage/content/team/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\TeamMembersController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\TeamMembersController@update',
        'as' => 'manage.content.team.update',
        'namespace' => NULL,
        'prefix' => 'manage/content/team',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'id' => '[0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.team.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/content/team/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\TeamMembersController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\TeamMembersController@destroy',
        'as' => 'manage.content.team.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/content/team',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'id' => '[0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.partners.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/partners',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PartnersController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PartnersController@index',
        'as' => 'manage.content.partners.index',
        'namespace' => NULL,
        'prefix' => 'manage/content/partners',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.partners.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/partners/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PartnersController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PartnersController@create',
        'as' => 'manage.content.partners.create',
        'namespace' => NULL,
        'prefix' => 'manage/content/partners',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.partners.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/content/partners',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PartnersController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PartnersController@store',
        'as' => 'manage.content.partners.store',
        'namespace' => NULL,
        'prefix' => 'manage/content/partners',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.partners.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/partners/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PartnersController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PartnersController@edit',
        'as' => 'manage.content.partners.edit',
        'namespace' => NULL,
        'prefix' => 'manage/content/partners',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'id' => '[0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.partners.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'manage/content/partners/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PartnersController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PartnersController@update',
        'as' => 'manage.content.partners.update',
        'namespace' => NULL,
        'prefix' => 'manage/content/partners',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'id' => '[0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.partners.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/content/partners/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\PartnersController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\PartnersController@destroy',
        'as' => 'manage.content.partners.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/content/partners',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'id' => '[0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.faqs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/faqs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@index',
        'as' => 'manage.content.faqs.index',
        'namespace' => NULL,
        'prefix' => 'manage/content/faqs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.faqs.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/faqs/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@create',
        'as' => 'manage.content.faqs.create',
        'namespace' => NULL,
        'prefix' => 'manage/content/faqs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.faqs.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/content/faqs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@store',
        'as' => 'manage.content.faqs.store',
        'namespace' => NULL,
        'prefix' => 'manage/content/faqs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.faqs.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/content/faqs/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@edit',
        'as' => 'manage.content.faqs.edit',
        'namespace' => NULL,
        'prefix' => 'manage/content/faqs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.faqs.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'manage/content/faqs/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@update',
        'as' => 'manage.content.faqs.update',
        'namespace' => NULL,
        'prefix' => 'manage/content/faqs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.faqs.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/content/faqs/{id}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@toggle',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@toggle',
        'as' => 'manage.content.faqs.toggle',
        'namespace' => NULL,
        'prefix' => 'manage/content/faqs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.content.faqs.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/content/faqs/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_pages',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Content\\FaqsController@destroy',
        'as' => 'manage.content.faqs.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/content/faqs',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.payments.transactions.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/payments/transactions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_payments',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Payments\\TransactionsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Payments\\TransactionsController@index',
        'as' => 'manage.payments.transactions.index',
        'namespace' => NULL,
        'prefix' => 'manage/payments',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.payments.transactions.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/payments/transactions/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_payments',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Payments\\TransactionsController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\Payments\\TransactionsController@show',
        'as' => 'manage.payments.transactions.show',
        'namespace' => NULL,
        'prefix' => 'manage/payments',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.payments.transactions.approve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/payments/transactions/{id}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_payments',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Payments\\TransactionsController@approve',
        'controller' => 'App\\Http\\Controllers\\Manage\\Payments\\TransactionsController@approve',
        'as' => 'manage.payments.transactions.approve',
        'namespace' => NULL,
        'prefix' => 'manage/payments',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'id' => '[0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.payments.transactions.reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/payments/transactions/{id}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_payments',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Payments\\TransactionsController@reject',
        'controller' => 'App\\Http\\Controllers\\Manage\\Payments\\TransactionsController@reject',
        'as' => 'manage.payments.transactions.reject',
        'namespace' => NULL,
        'prefix' => 'manage/payments',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'id' => '[0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.payments.transactions.proof' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/payments/transactions/{id}/proof',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_payments',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Payments\\TransactionsController@proof',
        'controller' => 'App\\Http\\Controllers\\Manage\\Payments\\TransactionsController@proof',
        'as' => 'manage.payments.transactions.proof',
        'namespace' => NULL,
        'prefix' => 'manage/payments',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'id' => '[0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.payments.methods.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/payments/methods',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_payments',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Payments\\MethodsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Payments\\MethodsController@index',
        'as' => 'manage.payments.methods.index',
        'namespace' => NULL,
        'prefix' => 'manage/payments',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.payments.methods.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/payments/methods/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_payments',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Payments\\MethodsController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\Payments\\MethodsController@edit',
        'as' => 'manage.payments.methods.edit',
        'namespace' => NULL,
        'prefix' => 'manage/payments',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.payments.methods.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'manage/payments/methods/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_payments',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Payments\\MethodsController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Payments\\MethodsController@update',
        'as' => 'manage.payments.methods.update',
        'namespace' => NULL,
        'prefix' => 'manage/payments',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.payments.methods.toggle' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'manage/payments/methods/{id}/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_payments',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Payments\\MethodsController@toggleStatus',
        'controller' => 'App\\Http\\Controllers\\Manage\\Payments\\MethodsController@toggleStatus',
        'as' => 'manage.payments.methods.toggle',
        'namespace' => NULL,
        'prefix' => 'manage/payments',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.payments.logs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/payments/logs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_payments',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Payments\\LogsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Payments\\LogsController@index',
        'as' => 'manage.payments.logs.index',
        'namespace' => NULL,
        'prefix' => 'manage/payments',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.payments.logs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/payments/logs/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:view_payments',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Payments\\LogsController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\Payments\\LogsController@show',
        'as' => 'manage.payments.logs.show',
        'namespace' => NULL,
        'prefix' => 'manage/payments',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.shipping.settings.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/shipping/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:shipping_settings|location_pricing',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Shipping\\SettingsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Shipping\\SettingsController@index',
        'as' => 'manage.shipping.settings.index',
        'namespace' => NULL,
        'prefix' => 'manage/shipping/settings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.shipping.settings.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/shipping/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:shipping_settings|location_pricing',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Shipping\\SettingsController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Shipping\\SettingsController@update',
        'as' => 'manage.shipping.settings.update',
        'namespace' => NULL,
        'prefix' => 'manage/shipping/settings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.shipping.pricing.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/shipping/pricing',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:shipping_settings|location_pricing',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Shipping\\PricingController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Shipping\\PricingController@index',
        'as' => 'manage.shipping.pricing.index',
        'namespace' => NULL,
        'prefix' => 'manage/shipping/pricing',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.shipping.pricing.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/shipping/pricing',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:shipping_settings|location_pricing',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Shipping\\PricingController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Shipping\\PricingController@store',
        'as' => 'manage.shipping.pricing.store',
        'namespace' => NULL,
        'prefix' => 'manage/shipping/pricing',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.shipping.pricing.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/shipping/pricing/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:shipping_settings|location_pricing',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Shipping\\PricingController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\Shipping\\PricingController@destroy',
        'as' => 'manage.shipping.pricing.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/shipping/pricing',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.newsletters.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/newsletters',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:newsletters',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\NewslettersController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\NewslettersController@index',
        'as' => 'manage.newsletters.index',
        'namespace' => NULL,
        'prefix' => 'manage/newsletters',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.newsletters.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/newsletters/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:newsletters',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\NewslettersController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\NewslettersController@store',
        'as' => 'manage.newsletters.store',
        'namespace' => NULL,
        'prefix' => 'manage/newsletters',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.newsletters.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/newsletters/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:newsletters',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\NewslettersController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\NewslettersController@destroy',
        'as' => 'manage.newsletters.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/newsletters',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.media.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/media',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:media',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\MediaController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\MediaController@index',
        'as' => 'manage.media.index',
        'namespace' => NULL,
        'prefix' => 'manage/media',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.media.upload' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/media/upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:media',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\MediaController@upload',
        'controller' => 'App\\Http\\Controllers\\Manage\\MediaController@upload',
        'as' => 'manage.media.upload',
        'namespace' => NULL,
        'prefix' => 'manage/media',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.media.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/media/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:media',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\MediaController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\MediaController@destroy',
        'as' => 'manage.media.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/media',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.media.refresh' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/media/refresh',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:media',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\MediaController@refresh',
        'controller' => 'App\\Http\\Controllers\\Manage\\MediaController@refresh',
        'as' => 'manage.media.refresh',
        'namespace' => NULL,
        'prefix' => 'manage/media',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.seo.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/settings/seo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
          6 => 'role:super_admin,admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\SeoController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\SeoController@index',
        'as' => 'manage.settings.seo.index',
        'namespace' => NULL,
        'prefix' => 'manage/settings/seo',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.seo.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/seo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
          6 => 'role:super_admin,admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\SeoController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\SeoController@update',
        'as' => 'manage.settings.seo.update',
        'namespace' => NULL,
        'prefix' => 'manage/settings/seo',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.seo.metadata' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/seo/metadata',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
          6 => 'role:super_admin,admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\SeoController@metadata',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\SeoController@metadata',
        'as' => 'manage.settings.seo.metadata',
        'namespace' => NULL,
        'prefix' => 'manage/settings/seo',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.branding.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/settings/branding',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\BrandingController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\BrandingController@index',
        'as' => 'manage.settings.branding.index',
        'namespace' => NULL,
        'prefix' => 'manage/settings/branding',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.branding.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/branding',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\BrandingController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\BrandingController@update',
        'as' => 'manage.settings.branding.update',
        'namespace' => NULL,
        'prefix' => 'manage/settings/branding',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.vat.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/settings/vat',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\VatController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\VatController@index',
        'as' => 'manage.settings.vat.index',
        'namespace' => NULL,
        'prefix' => 'manage/settings/vat',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.vat.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/vat',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\VatController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\VatController@store',
        'as' => 'manage.settings.vat.store',
        'namespace' => NULL,
        'prefix' => 'manage/settings/vat',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.vat.apply' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/vat/{id}/apply',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\VatController@apply',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\VatController@apply',
        'as' => 'manage.settings.vat.apply',
        'namespace' => NULL,
        'prefix' => 'manage/settings/vat',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.email.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/settings/email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\EmailController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\EmailController@index',
        'as' => 'manage.settings.email.index',
        'namespace' => NULL,
        'prefix' => 'manage/settings/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.email.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\EmailController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\EmailController@update',
        'as' => 'manage.settings.email.update',
        'namespace' => NULL,
        'prefix' => 'manage/settings/email',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.security.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/settings/security',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\SecurityController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\SecurityController@index',
        'as' => 'manage.settings.security.index',
        'namespace' => NULL,
        'prefix' => 'manage/settings/security',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.security.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/security',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\SecurityController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\SecurityController@update',
        'as' => 'manage.settings.security.update',
        'namespace' => NULL,
        'prefix' => 'manage/settings/security',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.contact.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/settings/contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\ContactController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\ContactController@index',
        'as' => 'manage.settings.contact.index',
        'namespace' => NULL,
        'prefix' => 'manage/settings/contact',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.contact.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\ContactController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\ContactController@update',
        'as' => 'manage.settings.contact.update',
        'namespace' => NULL,
        'prefix' => 'manage/settings/contact',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.sms.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/settings/sms',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\SmsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\SmsController@index',
        'as' => 'manage.settings.sms.index',
        'namespace' => NULL,
        'prefix' => 'manage/settings/sms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.sms.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/sms',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\SmsController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\SmsController@update',
        'as' => 'manage.settings.sms.update',
        'namespace' => NULL,
        'prefix' => 'manage/settings/sms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.sms.test' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/sms/test',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\SmsController@test',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\SmsController@test',
        'as' => 'manage.settings.sms.test',
        'namespace' => NULL,
        'prefix' => 'manage/settings/sms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.optimization.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/settings/optimization',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\OptimizationController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\OptimizationController@index',
        'as' => 'manage.settings.optimization.index',
        'namespace' => NULL,
        'prefix' => 'manage/settings/optimization',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.optimization.clear-cache' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/optimization/clear-cache',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\OptimizationController@clearCache',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\OptimizationController@clearCache',
        'as' => 'manage.settings.optimization.clear-cache',
        'namespace' => NULL,
        'prefix' => 'manage/settings/optimization',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.optimization.optimize-assets' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/optimization/optimize-assets',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\OptimizationController@optimizeAssets',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\OptimizationController@optimizeAssets',
        'as' => 'manage.settings.optimization.optimize-assets',
        'namespace' => NULL,
        'prefix' => 'manage/settings/optimization',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.settings.optimization.clean-database' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/settings/optimization/clean-database',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'permission:manage_settings',
          5 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\Settings\\OptimizationController@cleanDatabase',
        'controller' => 'App\\Http\\Controllers\\Manage\\Settings\\OptimizationController@cleanDatabase',
        'as' => 'manage.settings.optimization.clean-database',
        'namespace' => NULL,
        'prefix' => 'manage/settings/optimization',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.ajax.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/ajax/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\AjaxSearchController@search',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\AjaxSearchController@search',
        'as' => 'manage.ajax.search',
        'namespace' => NULL,
        'prefix' => '/manage',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.visitors-log.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/visitors-log',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\VisitorsLogController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\VisitorsLogController@index',
        'as' => 'manage.visitors-log.index',
        'namespace' => NULL,
        'prefix' => 'manage/visitors-log',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.system-users.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/system-users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@index',
        'as' => 'manage.system-users.index',
        'namespace' => NULL,
        'prefix' => 'manage/system-users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.system-users.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/system-users/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@create',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@create',
        'as' => 'manage.system-users.create',
        'namespace' => NULL,
        'prefix' => 'manage/system-users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.system-users.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/system-users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@store',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@store',
        'as' => 'manage.system-users.store',
        'namespace' => NULL,
        'prefix' => 'manage/system-users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.system-users.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/system-users/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@show',
        'as' => 'manage.system-users.show',
        'namespace' => NULL,
        'prefix' => 'manage/system-users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.system-users.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/system-users/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@edit',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@edit',
        'as' => 'manage.system-users.edit',
        'namespace' => NULL,
        'prefix' => 'manage/system-users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.system-users.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'manage/system-users/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@update',
        'as' => 'manage.system-users.update',
        'namespace' => NULL,
        'prefix' => 'manage/system-users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.system-users.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'manage/system-users/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@destroy',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\SystemUsersController@destroy',
        'as' => 'manage.system-users.destroy',
        'namespace' => NULL,
        'prefix' => 'manage/system-users',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.permissions.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/permissions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\PermissionsController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\PermissionsController@index',
        'as' => 'manage.permissions.index',
        'namespace' => NULL,
        'prefix' => 'manage/permissions',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.permissions.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/permissions/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\PermissionsController@update',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\PermissionsController@update',
        'as' => 'manage.permissions.update',
        'namespace' => NULL,
        'prefix' => 'manage/permissions',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.contact.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\ContactController@index',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\ContactController@index',
        'as' => 'manage.contact.index',
        'namespace' => NULL,
        'prefix' => 'manage/contact',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.contact.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manage/contact/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\ContactController@show',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\ContactController@show',
        'as' => 'manage.contact.show',
        'namespace' => NULL,
        'prefix' => 'manage/contact',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage.contact.reply' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/contact/{id}/reply',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:super_admin,admin,manager',
          3 => 'remember.session',
          4 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Manage\\System\\ContactController@reply',
        'controller' => 'App\\Http\\Controllers\\Manage\\System\\ContactController@reply',
        'as' => 'manage.contact.reply',
        'namespace' => NULL,
        'prefix' => 'manage/contact',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'seo.robots' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'robots.txt',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\SeoController@robots',
        'controller' => 'App\\Http\\Controllers\\Frontend\\SeoController@robots',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'seo.robots',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'seo.sitemap' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sitemap.xml',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\SeoController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\SeoController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'seo.sitemap',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'seo.sitemap.part' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sitemaps/{type}/{page}.xml',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\SeoController@part',
        'controller' => 'App\\Http\\Controllers\\Frontend\\SeoController@part',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'seo.sitemap.part',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'type' => 'pages|products|categories|projects|blog|content',
        'page' => '[0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.about' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'about',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:57:"function () {
    return \\view(\'frontend.about.index\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000007eb0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.about',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.blog' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'blog',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\BlogController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\BlogController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.blog',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.blog.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'blog/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\BlogController@show',
        'controller' => 'App\\Http\\Controllers\\Frontend\\BlogController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.blog.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.categories' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CategoryController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CategoryController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.categories',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.categories.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'categories/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CategoryController@show',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CategoryController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.categories.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\SearchController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\SearchController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.search',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.search.suggestions' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'search/suggestions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:120,1,suggestions',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\SearchController@suggestions',
        'controller' => 'App\\Http\\Controllers\\Frontend\\SearchController@suggestions',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.search.suggestions',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.products' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\ProductController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.products',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.products.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'products/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\ProductController@show',
        'controller' => 'App\\Http\\Controllers\\Frontend\\ProductController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.products.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.quotation.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\QuotationRequestController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\QuotationRequestController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.quotation.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.quotation.search' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotation/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\QuotationRequestController@search',
        'controller' => 'App\\Http\\Controllers\\Frontend\\QuotationRequestController@search',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.quotation.search',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.quotation.add' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'quotation/add',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\QuotationRequestController@add',
        'controller' => 'App\\Http\\Controllers\\Frontend\\QuotationRequestController@add',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.quotation.add',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.quotation.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'quotation/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\QuotationRequestController@update',
        'controller' => 'App\\Http\\Controllers\\Frontend\\QuotationRequestController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.quotation.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.quotation.remove' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'quotation/remove',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\QuotationRequestController@remove',
        'controller' => 'App\\Http\\Controllers\\Frontend\\QuotationRequestController@remove',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.quotation.remove',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.quotation.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'quotation/submit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:8,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\QuotationRequestController@submit',
        'controller' => 'App\\Http\\Controllers\\Frontend\\QuotationRequestController@submit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.quotation.submit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.referral.visit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ref/{code}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\ReferralController@visit',
        'controller' => 'App\\Http\\Controllers\\Frontend\\ReferralController@visit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.referral.visit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'code' => '[A-Za-z0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.cart' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cart',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CartController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CartController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.cart',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.cart.count' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cart/count',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CartController@count',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CartController@count',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.cart.count',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.cart.add' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'cart/add',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CartController@add',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CartController@add',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.cart.add',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.cart.remove' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'cart/remove',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CartController@remove',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CartController@remove',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.cart.remove',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.cart.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'cart/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CartController@update',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CartController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.cart.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.cart.abandon' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'cart/abandon',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CartController@abandon',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CartController@abandon',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.cart.abandon',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'mpesa.callback' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'payments/mpesa/mpesa_stk_callback_handler',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Payment\\MpesaController@handleCallback',
        'controller' => 'App\\Http\\Controllers\\Payment\\MpesaController@handleCallback',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'mpesa.callback',
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout.paystack.callback' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'payments/paystack/callback',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Payment\\PaystackController@handleCallback',
        'controller' => 'App\\Http\\Controllers\\Payment\\PaystackController@handleCallback',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.checkout.paystack.callback',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout.paystack.webhook' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'payments/paystack/webhook',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Payment\\PaystackController@handleWebhook',
        'controller' => 'App\\Http\\Controllers\\Payment\\PaystackController@handleWebhook',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
        ),
        'as' => 'frontend.checkout.paystack.webhook',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout.pesapal.callback' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'payments/pesapal/callback',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Payment\\PesapalController@handleCallback',
        'controller' => 'App\\Http\\Controllers\\Payment\\PesapalController@handleCallback',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.checkout.pesapal.callback',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout.pesapal.ipn' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'POST',
        2 => 'HEAD',
      ),
      'uri' => 'payments/pesapal/ipn',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Payment\\PesapalController@handleIpn',
        'controller' => 'App\\Http\\Controllers\\Payment\\PesapalController@handleIpn',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
        ),
        'as' => 'frontend.checkout.pesapal.ipn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'checkout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CheckoutController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CheckoutController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.checkout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'checkout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CheckoutController@store',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CheckoutController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.checkout.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout.locations' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'checkout/locations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CheckoutController@locations',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CheckoutController@locations',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.checkout.locations',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout.payment' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'checkout/payment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CheckoutController@payment',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CheckoutController@payment',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.checkout.payment',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout.payment.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'checkout/payment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CheckoutController@processPayment',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CheckoutController@processPayment',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.checkout.payment.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout.payment.resubmit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'checkout/payment/{code}/resubmit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\CheckoutController@resubmitPayment',
        'controller' => 'App\\Http\\Controllers\\Frontend\\CheckoutController@resubmitPayment',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.checkout.payment.resubmit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'code' => '[A-Za-z0-9]+',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout.mpesa.polling' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'checkout/mpesa/polling',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Payment\\MpesaController@pollingScreen',
        'controller' => 'App\\Http\\Controllers\\Payment\\MpesaController@pollingScreen',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.checkout.mpesa.polling',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout.mpesa.status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'checkout/mpesa/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Payment\\MpesaController@pollStatus',
        'controller' => 'App\\Http\\Controllers\\Payment\\MpesaController@pollStatus',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.checkout.mpesa.status',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.checkout.mpesa.timeout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'checkout/mpesa/timeout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Payment\\MpesaController@reportTimeout',
        'controller' => 'App\\Http\\Controllers\\Payment\\MpesaController@reportTimeout',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.checkout.mpesa.timeout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.testimonials' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'testimonials',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\ClientStoriesController@testimonials',
        'controller' => 'App\\Http\\Controllers\\Frontend\\ClientStoriesController@testimonials',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.testimonials',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.projects' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'client-projects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:64:"fn () => \\redirect()->route(\'frontend.project-gallery\', [], 301)";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009220000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.projects',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.projects.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'client-projects/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\ClientStoriesController@project',
        'controller' => 'App\\Http\\Controllers\\Frontend\\ClientStoriesController@project',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.projects.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.partners' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'partners',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\PartnerController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\PartnerController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.partners',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.team' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'our-team',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\TeamController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\TeamController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.team',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.project-gallery' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'project-gallery',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\ClientStoriesController@projects',
        'controller' => 'App\\Http\\Controllers\\Frontend\\ClientStoriesController@projects',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.project-gallery',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.faq' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'faq',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\FaqController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\FaqController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.faq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.contact' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\ContactController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\ContactController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.contact',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.track-order' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'track-order',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\OrderTrackingController@show',
        'controller' => 'App\\Http\\Controllers\\Frontend\\OrderTrackingController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.track-order',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.track-order.track' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'track-order',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:10,1,tracking',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\OrderTrackingController@track',
        'controller' => 'App\\Http\\Controllers\\Frontend\\OrderTrackingController@track',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.track-order.track',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.contact.us' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'contact-us',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:56:"fn () => \\redirect()->route(\'frontend.contact\', [], 301)";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009350000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.contact.us',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.contact.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'contact',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'throttle:5,1,contact',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\ContactController@store',
        'controller' => 'App\\Http\\Controllers\\Frontend\\ContactController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.contact.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.newsletter.subscribe' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'newsletter/subscribe',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:92:"function () {
    return \\redirect()->back()->with(\'success\', \'Subscribed successfully!\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009380000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.newsletter.subscribe',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.downloads' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'downloads',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:61:"function () {
    return \\view(\'frontend.downloads.index\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000093a0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.downloads',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.account-deletion' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account-deletion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:68:"function () {
    return \\view(\'frontend.account-deletion.index\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000093c0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.account-deletion',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.cookie-policy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cookie-policy',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:90:"fn () => \\app(\\App\\Http\\Controllers\\Frontend\\PageController::class)->show(\'cookie-policy\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000093e0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.cookie-policy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.terms' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'terms-conditions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\PageController@termsConditions',
        'controller' => 'App\\Http\\Controllers\\Frontend\\PageController@termsConditions',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.terms',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.refund-policy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'refund-policy',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\PageController@refundPolicy',
        'controller' => 'App\\Http\\Controllers\\Frontend\\PageController@refundPolicy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.refund-policy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.privacy-policy.public' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'privacy-policy',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\PageController@privacyPolicy',
        'controller' => 'App\\Http\\Controllers\\Frontend\\PageController@privacyPolicy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.privacy-policy.public',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.pages.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'pages/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\PageController@canonicalShow',
        'controller' => 'App\\Http\\Controllers\\Frontend\\PageController@canonicalShow',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.pages.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.account' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'account',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:39:"fn() => \\view(\'frontend.account.index\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009440000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.account',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.favorites' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'favorites',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:41:"fn() => \\view(\'frontend.favorites.index\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009460000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.favorites',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.brands' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'brands',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\BrandController@index',
        'controller' => 'App\\Http\\Controllers\\Frontend\\BrandController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.brands',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'frontend.brands.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'brands/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\BrandController@show',
        'controller' => 'App\\Http\\Controllers\\Frontend\\BrandController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'frontend.brands.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'storage.local' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:3:{s:4:"disk";s:5:"local";s:6:"config";a:5:{s:6:"driver";s:5:"local";s:4:"root";s:49:"C:\\xampp\\htdocs\\trinitymabati\\storage\\app/private";s:5:"serve";b:1;s:5:"throw";b:0;s:6:"report";b:0;}s:12:"isProduction";b:1;}s:8:"function";s:323:"function (\\Illuminate\\Http\\Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new \\Illuminate\\Filesystem\\ServeFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                }";s:5:"scope";s:47:"Illuminate\\Filesystem\\FilesystemServiceProvider";s:4:"this";N;s:4:"self";s:32:"000000000000094a0000000000000000";}}',
        'as' => 'storage.local',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'storage.local.upload' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:3:{s:4:"disk";s:5:"local";s:6:"config";a:5:{s:6:"driver";s:5:"local";s:4:"root";s:49:"C:\\xampp\\htdocs\\trinitymabati\\storage\\app/private";s:5:"serve";b:1;s:5:"throw";b:0;s:6:"report";b:0;}s:12:"isProduction";b:1;}s:8:"function";s:325:"function (\\Illuminate\\Http\\Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new \\Illuminate\\Filesystem\\ReceiveFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                }";s:5:"scope";s:47:"Illuminate\\Filesystem\\FilesystemServiceProvider";s:4:"this";N;s:4:"self";s:32:"000000000000094c0000000000000000";}}',
        'as' => 'storage.local.upload',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
