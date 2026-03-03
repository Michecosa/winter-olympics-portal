# File Tree: backoffice

```
├── app
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── Admin
│   │   │   │   ├── AthleteController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── DisciplineController.php
│   │   │   ├── Api
│   │   │   │   ├── AthleteController.php
│   │   │   │   └── DisciplineController.php
│   │   │   ├── Auth
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── ConfirmablePasswordController.php
│   │   │   │   ├── EmailVerificationNotificationController.php
│   │   │   │   ├── EmailVerificationPromptController.php
│   │   │   │   ├── NewPasswordController.php
│   │   │   │   ├── PasswordController.php
│   │   │   │   ├── PasswordResetLinkController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   └── VerifyEmailController.php
│   │   │   ├── Controller.php
│   │   │   └── ProfileController.php
│   │   └── Requests
│   │       ├── Auth
│   │       │   └── LoginRequest.php
│   │       └── ProfileUpdateRequest.php
│   ├── Models
│   │   ├── Athlete.php
│   │   ├── Country.php
│   │   ├── Discipline.php
│   │   └── User.php
│   └── Providers
│       └── AppServiceProvider.php
├── bootstrap
├── config
├── public
├── resources
│   ├── js
│   │   ├── app.js
│   │   └── bootstrap.js
│   ├── scss
│   │   └── app.scss
│   └── views
│       ├── admin
│       │   ├── athletes
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── disciplines
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   └── homepage.blade.php
│       ├── auth
│       ├── layouts
│       │   ├── app.blade.php
│       │   └── guest.blade.php
│       ├── profile
│       ├── dashboard.blade.php
│       └── welcome.blade.php
├── routes
│   ├── api.php
│   ├── auth.php
│   ├── console.php
│   └── web.php
├── storage
├── tests
├── .editorconfig
├── .env.example
├── .gitattributes
├── .gitignore
├── README.md
├── artisan
├── composer.json
├── package-lock.json
├── package.json
├── phpunit.xml
└── vite.config.js
```

