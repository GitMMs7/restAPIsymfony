# Symfony Rest API
> Projekt API wętpnie do obsługi komunikacji z bazą dla aplikacji produkty
> brak .env brak fabryk brak generatora tabel wybagane utworzenie tabel dla obu typów uzytkowników

<p>
    <img width="90" src="./img/php-logo.svg" >
    <img width="90" src="./img/symfony.svg" >
    <img width="90" src="./img/mysql.svg" >
</p>


## Table of Contents
* [General Info - informacje ogólne](#general-information)
* [Technologies Used - użyte technologie](#technologies-used)
* [Features - Funkcje](#features)
* [Setup — Instalacja i wymagania](#setup)
* [Usage — Używanie](#usage)
* [Project Status — Status projektu](#project-status)
* [Room for Improvement - Do poprawy lub do zrobienia](#room-for-improvement)
* [Acknowledgements — Odnośniki](#acknowledgements)
* [Contact](#contact)
<!-- * [License](#license) -->



## General Information
- Pierwsza działająca wersja
- Rest API w Symfony
- pna razie z przeznaczeniem dla Angular_produkty
- wstępny wygląd tabeli nazwa = produkty
- kolumny id: number; name: string; content: longtext; group: number;


## Technologies Used
- Symfony: 5.4
- php: 8.1
- php-cli: 8.1
- MySql: 8.0.28


## Features
* funkcje dotyczące produktów: 
   * 1: pobieranie produktów
     * /get/produkty  pobiera wszystkie rekordy
     * /get/produkt/{id}  pobiera cały rekord o numerze id
   * 2: dodawanie produktów (należy podać dopowiedni token)
     * /auth/add/produkt  dodaje nowy produkt atrybuty POST -em
   * 3: aktualizacja produktów / produku (należy podać dopowiedni token)
     * /auth/update/produkt/{id} aktualizacja całego rekordu o numerze id wszystkie jego atrybuty POST -em
     * /auth/update/name/produkt/{id} aktualizacja atrybutu name rekordu o numerze id POST -em
     * /auth/update/grupa/produkt/{id} aktualizacja atrybutu grupa rekordu o numerze id POST -em
     * /auth/update/content/produkt/{id} aktualizacja atrybutu content rekordu o numerze id POST -em
   * 4: usuwanie produku
     * /auth/delete/produkt/{id} usuwanie rekordu o numerze id
* funkcje dotyczące użytkowników (należy podać dopowiedni token)
  * 1: rejestracja użytkownika
    * /admin/register  dodawanie nowego użytkownika
  * 2: usuwanie użytkownika
    * /admin/delete/user/{id}  usuwanie użytkownika o podanym id
* funkcje dotyczące zabezpieczeń
  * 1: pobieranie tokenu do zarządzania produktami
    * /auth/login_check
  * 2: pobieranie tokenu do zarządzania użytkownikami
    * /admin/login_check


## Setup
Wymagania związane z zależnościami symfony są w pliku composer.json.
Oprócz tego wymagane jest:
zainstalowane
php
php-cli
MySql ( symfony musi mieś poprawną konfigurację do pracy z MySql)

W celu zmodyfikowania tabel trzeba zmienić ORM -y oraz setery i getery, a następnie wypchnąć tabelę do mysql

Instalacja instancji projektu wykonać
```bash
git@192.168.8.212:mmarchowski/symfonyrestapi.git
```
lub
```bash
http://192.168.8.212/mmarchowski/symfonyrestapi.git
```

## Usage
API pozwalające zapytać o dane z MySql, obecne możliwości:
```bash
http://restapi.devteam.net.pl/get/produkty/
```
Żeby odpytań o wszystkie produkty z bazy, lub

```bash
http://restapi.devteam.net.pl/get/produkt/{id}
```
Żeby uzyskać w odpowiedzi wszystkie dane rekordu o konkretnym id.

```bash
http://restapi.devteam.net.pl/auth/add/produkt
```
Aby dodać rekord do bazy (wymagany odpowiedni token)

```bash
http://restapi.devteam.net.pl/auth/update/produkt/{id}
http://restapi.devteam.net.pl/auth/update/name/produkt/{id}
http://restapi.devteam.net.pl/auth/update/grupa/produkt/{id}
http://restapi.devteam.net.pl/auth/update/content/produkt/{id}
```

Oraz aby zaktualizować cały rekord lub jeden z jego atrybutów (wymagany odpowiedni token)
```bash
http://restapi.devteam.net.pl/auth/delete/produkt/{id}
```

Aby usunąć rekord (wymagany odpowiedni token)

Sekcja zarządzania użytkownikami
```bash
http://restapi.devteam.net.pl/admin/register
```

Pozwala dodać nowego użytkownika do zarządzania produktami
```bash
http://restapi.devteam.net.pl/admin/delete/user/{id}
```

Pozwala usunąć użytkownika mającego uprawnienia do zarządzania produktami 

```bash
https://restapi.devteam.net.pl/auth/login_check
https://restapi.devteam.net.pl/admin/login_check
```

Pozwalają odpowiednio na pobranie odpowiedniego tokena wymagają podania danych logowania
`write-your-code-here`

Aby uzyskać rekord z wybranym ID
```php
    public function getOne(int $id, ProductRepository $ProductRepository ): JsonResponse //: JsonResponse
    {

        $data = $ProductRepository->find($id);
        if ($data) {
            return $this->json($data);
        } else {
            return $this->json(["error" => "Post was not found by id:" . $id], 404);
        }

    }
```

Aby dodać rekord do produktów
```php
    public function addOne(Request $Request, EntityManagerInterface $entityManager, ProductRepository $ProductProductRepository)
    {
    try
        {
        $request = json_decode($Request->getContent(), true, 200, JSON_THROW_ON_ERROR);

            if(!isset($request) || !isset($request['name' ],$request['content'],$request['grupa']))
            {
                throw new \Exception();
		
            }

            $product = new Product();
            $product->setName($request['name']);
            $product->setContent($request['content']);
            $product->setGrupa($request['grupa']);
            $entityManager->persist($product);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "rekord dodany z powodzeniem",
            ];
	        $Response = new JsonResponse($data,200);
            return $Response->send();
        }
        catch (\Exception $e)
        {
            $data = [
                'status' => 422,
                'success' => "Dane niepoprawne",
            ];
	        $Response = new JsonResponse($data,422);
            $Response->send();
        }
    }
```

Aby zaktualizować cały rekord (pozostałe aktualizacje wyglądają podobnie)
```php
    public function updateAll(Request $Request, EntityManagerInterface $entityManager, ProductRepository $ProductRepository, int $id): Response //: JsonResponse
    {
        try {
            $produkt = $ProductRepository->find($id);
            if(!$produkt)
            {
                $data = [
                    'status' => 404,
                    'errors' => 'Produkt nie znaleziony',
                ];

                return new JsonResponse($data,204);
            }

            $request = json_decode($Request->getContent(), true, 200, JSON_THROW_ON_ERROR);
            if(!isset($request) || !isset($request['name' ], $request['content'], $request['grupa']))
            {
                throw new \Exception();
            }

            $product = new Product();
            $product = $entityManager->getRepository(Product::class)->find($id);
            $product->setName($request['name']);
            $product->setContent($request['content']);
            $product->setGrupa($request['grupa']);
            $entityManager->flush();
            $data = [
                'status' => 200,
                'errors' => 'Produkt zaktualizowany z sukcesem',
            ];
            return new JsonResponse($data,200);
        }
        catch (\Exception $e)
        {
            $data = [
                'status' => 422,
                'errors' => 'Nieprawidłowe dane',
            ];
            return new JsonResponse($data,422);
        }
    }
```

Żeby usunąć rekord
```php
public function deleteOne(EntityManagerInterface $entityManager, ProductRepository $ProductRepository, int $id): Response
    {

        $produkt = $ProductRepository->find($id);
        if(!$produkt)
        {
            $data = [
                'status' => 404,
                'errors' => 'Produkt nie znaleziony',
            ];
            return new JsonResponse($data,204);

            }
            $entityManager->remove($produkt);
            $entityManager->flush();
            $data = [
                'status' => 200,
                'errors' => 'Produkt usunięty',
            ];
            return new JsonResponse($data,200);
    }
```

Aby było możliwe działanie zabezpieczeń zintegrowanych w symfony wymagana jest odpowiednia konfiguracja w pliku
> config/packages/security.yaml
* poszczególne sekcje konfiguracja
  * encoders — zawiera źródła zawierające informacje o użytkownikach i hasłach do wykorzystania w procesie weryfikacji oraz metodę parsowania tokenu
```yaml
    encoders:
        App\Entity\User:
            algorithm: bcrypt
```
  * providers — przypisuje trasę konkretnej encji konkretnej bazy użytkowników do tymczasowej nazwy wykorzystanej niżej
```yaml
    providers:
      users:
        entity:
          class: App\Entity\User
          property: username
``` 
  * firewalls — tworzy człon adresu, który łączy z modułem lexik_jwt_authentication oraz wskazuje, który providers i encoders będą użyte do tworzenia tokenu
```yaml
    firewalls:
      login:
        pattern: ^/auth/login
        stateless: true
        anonymous: false
        json_login: # or form_login
          provider: users
          check_path: /auth/login_check  #same as the configured route
          success_handler: lexik_jwt_authentication.handler.authentication_success
          failure_handler: lexik_jwt_authentication.handler.authentication_failure
          require_previous_session: false
``` 
  * access_control — przydziela role dla każdego z wariantu bezpieczeństwa
```yaml
    access_control:
      - { path: ^/auth/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
      - { path: ^/admin/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
      - { path: ^/auth, roles: IS_AUTHENTICATED_FULLY }
      - { path: ^/admin, roles: IS_AUTHENTICATED_FULLY }
``` 
## Project Status
Project is: _in progress_


## Room for Improvement

Room for improvement - Do poprawy :
- ??

To do - Do zrobienia:
- ??


## Acknowledgements

- Miejsce, gdzie znajduje się rozwojowa wersja aplikacji [link do api na devteam](http://restapi.devteam.net.pl/produkt/).
- Miejsce aplikacji w Angular wykorzystującej API [link do aplikacji Produkty](https://crm.mateusz.devteam.net.pl/)


## Contact
kontakt [mms72525@gmail.com](mms72525@gmail.com)


<!-- Optional -->
<!-- ## License -->
<!-- This project is open source and available under the [... License](). -->

<!-- You don't have to include all sections - just the one's relevant to your project -->
