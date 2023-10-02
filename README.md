# ThrowableHandler

> 🔔 Subscribe to the [newsletter](https://chv.to/chevere-newsletter) to don't miss any update regarding Chevere.

![Chevere](chevere.svg)

[![Build](https://img.shields.io/github/actions/workflow/status/chevere/throwable-handler/test.yml?branch=0.11&style=flat-square)](https://github.com/chevere/throwable-handler/actions)
![Code size](https://img.shields.io/github/languages/code-size/chevere/throwable-handler?style=flat-square)
[![Apache-2.0](https://img.shields.io/github/license/chevere/throwable-handler?style=flat-square)](LICENSE)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%209-blueviolet?style=flat-square)](https://phpstan.org/)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat-square&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fchevere%2Fthrowable-handler%2F0.11)](https://dashboard.stryker-mutator.io/reports/github.com/chevere/throwable-handler/0.11)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=chevere_throwable-handler&metric=alert_status)](https://sonarcloud.io/dashboard?id=chevere_throwable-handler)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=chevere_throwable-handler&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=chevere_throwable-handler)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=chevere_throwable-handler&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=chevere_throwable-handler)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=chevere_throwable-handler&metric=security_rating)](https://sonarcloud.io/dashboard?id=chevere_throwable-handler)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=chevere_throwable-handler&metric=coverage)](https://sonarcloud.io/dashboard?id=chevere_throwable-handler)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=chevere_throwable-handler&metric=sqale_index)](https://sonarcloud.io/dashboard?id=chevere_throwable-handler)
[![CodeFactor](https://www.codefactor.io/repository/github/chevere/throwable-handler/badge)](https://www.codefactor.io/repository/github/chevere/throwable-handler)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/cc09a56d15814ffd9066dcd19a5654c7)](https://app.codacy.com/gh/chevere/throwable-handler/dashboard)

![ThrowableHandler](.github/banner/throwable-handler-logo.svg)

## Quick start

Install ThrowableHandler using [Composer](https://getcomposer.org).

```sh
composer require chevere/throwable-handler
```

Register ThrowableHandler to handle all errors.

```php
use Chevere\ThrowableHandler\ThrowableHandler;

set_error_handler(ThrowableHandler::ERROR_AS_EXCEPTION);
register_shutdown_function(ThrowableHandler::SHUTDOWN_ERROR_AS_EXCEPTION);
```

Register your exception handler, you can choose:

* `ThrowableHandler::PLAIN`
* `ThrowableHandler::CONSOLE`
* `ThrowableHandler::HTML`

```php
use Chevere\ThrowableHandler\ThrowableHandler;

set_exception_handler(ThrowableHandler::PLAIN);
```

## Demo

![HTML demo](demo/demo.svg)

* [HTML](https://chevere.github.io/throwable-handler/demo/output/html.html)
* [HTML (silent)](https://chevere.github.io/throwable-handler/demo/output/html-silent.html)
* [Plain text](https://chevere.github.io/throwable-handler/demo/output/plain.txt)
* [Console (asciinema)](https://asciinema.org/a/491732)

## Documentation

Documentation is available at [chevere.org](https://chevere.org/packages/throwable-handler).

## License

Copyright 2023 [Rodolfo Berrios A.](https://rodolfoberrios.com/)

Chevere is licensed under the Apache License, Version 2.0. See [LICENSE](LICENSE) for the full license text.

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
