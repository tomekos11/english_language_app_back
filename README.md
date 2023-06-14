<h1>1. OPIS PROJEKTU</h1>
    <a title="Podgląd aplikacji" href="http://www.english-language-app.pl/">English Learning App </a>to aplikacja internetowa, stworzona przy użyciu frameworka Laravel, zaprojektowana, aby pomóc użytkownikom w doskonaleniu znajomości języka angielskiego. Projekt jest nieustannie rozwijany i planowo w niedalekiej przyszłości pojawić się mają nowe funkcjonalności - ranking tygodniowy, money management, system nowych gier, admin-page oraz połączenie ze sztuczną inteligencją.<br><br>
    Projekt składa się z kilku części takich jak testy, powtórki, osiągnięcia, gry czasowe, quizy itp. Podczas pracy nad projektem zrozumiałem piękno i możliwości backendu i zdecydowałem, że warto się go trzymać.
<br><br><br>

<h1>2. MÓJ WKŁAD</h1>
    Jestem odpowiedzialny za rozwój backendu, w tym kluczowe zadania, takie jak między innymi Migrations, Models, API, Seeders, Listeners, Scheduler oraz połączenie ze storage'm.<br>
    Sytuacja zmusiła mnie również do praktykowania frontendu, dzięki czemu zagłębiłem się w VueJS i poznałem również ten framework - Słownik oraz Dashboard pośród wielu innych wyszły spod mojej ręki.
<br><br><br>

<h1>3. JAK ZAINSTALOWAĆ PROJEKT</h1>
Do poprawnego działania aplikacji wymagane są:<br>

- <b>PHP w wersji ^8.0<br>
- Composer<br>
- Baza danych np. MySQL, PostgreSQL, SQLite</b><br>


Po pobraniu projektu, musimy dostosować lokalny plik .env, w którym przetrzymywana jest konfiguracja naszego serwera, w tym informacje o bazie danych, z jakiej korzystamy.<br>
Po zainstalowaniu wszystkich koniecznych do działania komponentów, oraz poprawnym skonfigurowaniu pliku .env, możemy przejść testowania funkcjonalności.

Zaczynamy od użycia komend:<br>
- <b>php artisan migrate</b> - komenda używana jest w celu stworzenia bazy danych.
- <b>php artisan db:seed</b> - komenda używana jest w celu wstrzyknięcia do bazy danych, rekordów wymaganych do popranego działania serwera - słowa, kategorie itp.
- <b>php artisan passport:install</b> - komenda używana jest w celu służy instalacji i konfiguracji infrastruktury uwierzytelniania OAuth2
<br><br><br>
<h1>4. TESTOWANIE</h1>
  
W celu uproszczenia nawigacji, projekt podzielony został na 3 moduły takie jak - Auth, Words oraz System.
<pre><h3>Moduł <u>Auth</u></h3>W module Auth przetrzymywane są wszystkie pliki odnoszące się do użytkowników oraz ich danych osobowych.<br>
<h3>Moduł <u>Word</u></h3>Następny moduł to Word, przetrzymuje on pliki związane ze słowami - kategorie, testy, ćwieczenia, a także rodzaje ćwiczen.<br>
<h3>Moduł <u>System</u></h3>Ostatnim z modułów jest System, w którym dostępne są logi, statystyki użytkowników, informacje o aktualiazjach na serwerze, rezultaty gier czasowych, osiągnięcia.</pre>
<h2>4.1 API</h2>

<details>
    <summary>Wyświetl zapytania dla modułu <b><u>Word</u></b></summary>
        <table style="text-align:center;">
            <tr>
                <th style="text-align:center";>Rodzaj</th>
                <th style="text-align:center";>Adres</th>
                <th style="text-align:center";>Wymagane pola</th>
                <th style="text-align:center";>Wymagane ranga</th>
                <th style="text-align:center";>Opis</th>
            </tr>
            <tr>
                <td><span style="color:green ">GET</span></td>
                <td>api/word/dict</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie służy do pobierania listy kategorii oraz ilości słów dla każdej z nich</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/dict</td>
                <td><a title="nazwa kategorii jest wymagana. W tym zapytaniu można również wysłać 'Wszystkie kategorie', zwróci to słowa dla wszystkich dostępnych kategorii.">category</a></td>
                <td>user</td>
                <td>Zapytanie służy do pobrania listy słów dla danej kategorii</td>
            </tr>
            <tr>
                <td><span style="color:green ">GET</span></td>
                <td>api/word/word/{nr}</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie służy do pobrania informacji o konkretnym słowie. Dostajemy się do niego poprzez podanie w miejscu {nr} indeksu słowa z bazy danych</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/word</td>
                <td><a title="wymagane">category_id</a>, <a title="wymagane, minimalna liczba znaków:1, maksymalna:255">word_en</a>, <a title="wymagane, minimalna liczba znaków:1, maksymalna:255">word_pl</a>, <a title="wymagana, musi odpowiadać wartościom zdefiniowanych poziomów trudności - easy, medium lub hard">difficulty</a></td>
                <td>admin</td>
                <td>Zapytanie służy do dodania nowego słowa do bazy danych</td>
            </tr>
            <tr>
                <td><span style="color:violet ">PATCH</span></td>
                <td>api/word/word/{nr}</td>
                <td><a title="minimalna liczba znaków:1, maksymalna:255">word_en</a>, <a title="minimalna liczba znaków:1, maksymalna:255">word_pl</a>, <a title="musi odpowiadać wartościom zdefiniowanych poziomów trudności - easy, medium lub hard">difficulty</a></td>
                <td>admin</td>
                <td>Zapytanie służy do zaktualizowania istniejącego już słowa w bazie danych.<br> {nr} - indeks słowa w bazie danych</td>
            </tr>
            <tr>
                <td><span style="color:red ">DELETE</span></td>
                <td>api/word/word/{nr}</td>
                <td>-</td>
                <td>admin</td>
                <td>Zapytanie służy do usuwania istniejącego już słowa w bazie danych.<br> {nr} - indeks słowa w bazie danych</td>
            </tr>
            <tr>
                <td><span style="color:green ">GET</span></td>
                <td>api/word/word/wordoftheday</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie służy do zwracania wszystkich informacji dotyczących słowa dnia</td>
            </tr>
            <tr>
                <td><span style="color:green ">GET</span></td>
                <td>api/word/repetitions/favourite</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie służy do zwracania wszystkich ulubionych słów użytkownika wraz z ich szczegółami</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/word/{nr}/addtofavourite</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie służy do dodania słówka przez użytkownika do ulubionych.<br> {nr} - indeks słowa</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/word/{nr}/revokefromfavourite</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie służy do usuwania słówka przez użytkownika z jego ulubionych słów.<br> {nr} - indeks słowa</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/word/{nr}/addnote</td>
                <td><a title="obecne, może przyjąć pustą wartość">notes</a></td>
                <td>user</td>
                <td>Zapytanie służy do przypisywania notatek użytkownika do słówka.<br> {nr} - indeks słowa</td>
            </tr>
            <tr>
                <td><span style="color:green ">GET</span></td>
                <td>api/word/repetitions/review</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie służy do zwracania wszystkich słów, które użytkownik chce powtarzać (powtórek)</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/word/{nr}/addtoreview</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie służy do dodania słówka przez użytkownika do powtórek.<br> {nr} - indeks słowa</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/word/{nr}/revokefromreview</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie służy do usuwania słówka przez użytkownika z jego powtórek.<br> {nr} - indeks słowa</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/repetitions/review</td>
                <td><a title="id słowa, które wykonaliśmy[min:1 max:4000, wymagane, musi być liczbą całkowitą]">id</a></td>
                <td>user</td>
                <td>Zapytanie służy do zmiany statusu powtórki na wykonaną</td>
            </tr>
            <tr>
                <td><span style="color:green ">GET</span></td>
                <td>api/word/repetitions/category</td>
                <td><a title="nazwa kategorii jest wymagana oraz taka kategoria musi rzeczywiście istnieć w bazie">category</a></td>
                <td>user</td>
                <td>Zapytanie zwraca listę powtórek dla konkretnie wskazanej kategorii</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/repetitions/refresh</td>
                <td><a title="nazwa kategorii jest wymagana oraz taka kategoria musi rzeczywiście istnieć w bazie">category</a></td>
                <td>user</td>
                <td>Zapytanie zmienia status wykonania powtórki, ładując użytkownikowi do ponownego rozwiązania</td>
            </tr>
            <tr>
                <td><span style="color:green ">GET</span></td>
                <td>api/word/repetitions/categories_list</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie zwraca ilość niezrobionych oraz ilość wszystkich dodanych do tej pory powtórek dla każdej z kategorii</td>
            </tr>
            <!-- API DLA KATEGORII -->
            <tr>
                <td><span style="color:green ">GET</span></td>
                <td>api/word/category</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie zwraca wszystkie kategorie oraz informacje o nich</td>
            </tr>
            <tr>
                <td><span style="color:green ">GET</span></td>
                <td>api/word/category/{nr}</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie zwraca konkretną kategorię oraz informacje o niej</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/category</td>
                <td><a title="nazwa kategorii - jest wymagana, musi zawierać 3 znaki, musi być inna niż wszystkie dodane do tej pory">name</a></td>
                <td>admin</td>
                <td>Zapytanie tworzy nową kategorię</td>
            </tr>
            <tr>
                <td><span style="color:violet ">PATCH</span></td>
                <td>api/word/category/{nr}</td>
                <td><a title="nazwa kategorii - jest wymagana, musi zawierać 3 znaki, musi być inna niż wszystkie dodane do tej pory">name</a></td>
                <td>admin</td>
                <td>Zapytanie aktualizuje wskazana kategorię<br>{nr} - to id kategorii</td>
            </tr>
            <tr>
                <td><span style="color:red ">DELETE</span></td>
                <td>api/word/category/{nr}</td>
                <td>-</td>
                <td>admin</td>
                <td>Zapytanie usuwa wskazana kategorię<br>{nr} - to id kategorii</td>
            </tr>
            <tr>
                <td><span style="color:green ">GET</span></td>
                <td>api/word/test</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie pobiera wszystkie testy użytkownika - ich statusy, date wykonania, kategorię oraz trudność</td>
            </tr>
            <tr>
                <td><span style="color:green ">GET</span></td>
                <td>api/word/test/{nr_testu}</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie pobiera wszystkie zadania dla testu wskazanego przez użytkownika<br>{nr_testu} - to numer testu z bazy danych [1-63]</td>
            </tr>
            <tr>
                <td><span style="color:green ">GET</span></td>
                <td>api/word/test/{nr_testu}/{nr_zadania}</td>
                <td>-</td>
                <td>user</td>
                <td>Zapytanie pobiera wszystkie szczegóły dla konkretnego zadania, w wybranym przez użytkownika teście<br>{nr_testu} - to numer testu z bazy danych [1-63]<br>{nr_zadania} - numer zadania z bazy danych [1-11]</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/test/{nr_testu}/{nr_zadania}</td>
                <td><a title="Brak specjalnych wymogów. Zła odpowiedź = utrata życia">answer_fill_sentence</a></td>
                <td>user</td>
                <td>Zapytanie wysyła odpowiedź na zadanie typu "uzupełnij lukę"<br>{nr_testu} - to numer testu z bazy danych [1-63]<br>{nr_zadania} - numer zadania z bazy danych [1-11]</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/test/{nr_testu}/{nr_zadania}</td>
                <td><a title="Wymagany fomat to json - tablica obiektów z kluczami word_pl oraz word_en. Każda pomyłka = utrata życia.">pairs</a></td>
                <td>user</td>
                <td>Zapytanie wysyła odpowiedź na zadanie typu "połącz pary"<br>{nr_testu} - to numer testu z bazy danych [1-63]<br>{nr_zadania} - numer zadania z bazy danych [1-11]</td>
            </tr>
            <tr>
                <td><span style="color:orange ">POST</span></td>
                <td>api/word/test/{nr_testu}/{nr_zadania}</td>
                <td><a title="Wymagany fomat to json - tablica stringów. Każda pomyłka = utrata życia.">answer</a></td>
                <td>user</td>
                <td>Zapytanie wysyła odpowiedź na zadanie typu "ułóż układankę"<br>{nr_testu} - to numer testu z bazy danych [1-63]<br>{nr_zadania} - numer zadania z bazy danych [1-11]</td>
            </tr>
        </table>
</details>

<!-- AUTH requests-->
<details>
<summary>Auth</summary>
<table style="text-align:center;">
    <tr>
        <th>Rodzaj</th>
        <th>Adres</th>
        <th>Wymagane pola</th>
        <th>Wymagane ranga</th>
        <th>Opis</th>
    </tr>
    <tr>
        <td><span style="color:orange ">POST</span></td>
        <td>api/auth/login</td>
        <td><a title="wymagane">email</a>, <a title="wymagane">password</a></td>
        <td>-</td>
        <td>Zapytanie służy do zalogowania użytkownika</td>
    </tr>
    <tr>
        <td><span style="color:orange ">POST</span></td>
        <td>api/auth/register</td>
        <td><a title="wymagane, email:rfc">email</a>, <a title="wymagane, 8 znaków, jeden znak specjalny, jedna duża litera">password</a>, <a title="wymagane, imie, nazwisko, data urodzenia">dane użytkownika</a></td>
        <td>-</td>
        <td>Zapytanie służy do rejestracji nowego użytkownika</td>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td>
        <td>api/auth/logout</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do wylogowania użytkownika</td>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td>
        <td>api/auth/user/data/dashboard</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwracania wszystkich informacji wyświetlanych w dashboardzie</td>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td>
        <td>api/auth/user/data/me</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwracania informacji o użytkowniku</td>
    </tr>
    <tr>
        <td><span style="color: violet">PATCH</span></td>
        <td>api/auth/user/data/change_data</td>
        <td><a title="wymagane">name</a>, <a title="wymagane">surname</a>, <a title="wymagane">birth_date</a></td>
        <td>user</td>
        <td>Zapytanie służy do zmiany danych użytkownika</td>
    </tr>
    <tr>
        <td><span style="color: orange">POST</span></td>
        <td>api/auth/user/data/change_avatar</td>
        <td><a title="wymagane, formaty: jpg, png, gif, svg, jpeg">avatar</a></td>
        <td>user</td>
        <td>Zapytanie służy do zmiany avataru użytkownika</td>
    </tr>
    <tr>
        <td><span style="color: green">GET</span></td>
        <td>api/auth/user/role/me</td>
        <td>-</td>
        <td>admin</td>
        <td>Zapytanie służy do otrzymania informacji o roli jaką posiada użytkownik</td>
    </tr>
    <tr>
        <td><span style="color: green">GET</span></td>
        <td>api/auth/user/role/{user}</td>
        <td>-</td>
        <td>admin</td>
        <td>Zapytanie służy do sprawdzenia roli innego użytkownika [user] - id użytkownika</td>
    </tr>
    <tr>
        <td><span style="color: orange">POST</span></td>
        <td>api/auth/user/role/{user}</td>
        <td><a title="wymagane, rola admin lub user">role</a></td>
        <td>admin</td>
        <td>Zapytanie służy do zmiany roli innego użytkownika [user] - id użytkownika</td>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td> 
        <td>api/auth/ranking/money</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwrócenia rankingu użytkowników względem posiadanych monet</td>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td> 
        <td>api/auth/ranking/lvl</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwrócenia rankingu użytkowników względem posiadanego poziomu</td>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td> 
        <td>api/auth/ranking/15s</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwrócenia rankingu użytkowników względem zdobytych punktów w grze 15s</td>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td> 
        <td>api/auth/ranking/30s</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwrócenia rankingu użytkowników względem zdobytych punktów w grze 30s</td>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td> 
        <td>api/auth/ranking/60s</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwrócenia rankingu użytkowników względem zdobytych punktów w grze 60s</td>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td> 
        <td>api/auth/ranking/all</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwrócenia rankingu użytkowników posiadającego wszystkie powyższe</td>
    </tr>
</table>
</details>
<details>
<summary>System</summary>
<table style="text-align:center;">
    <tr>
        <th>Rodzaj</th>
        <th>Adres</th>
        <th>Wymagane pola</th>
        <th>Wymagane ranga</th>
        <th>Opis</th>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td> 
        <td>api/system/statistics</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwrócenia podstawowych statystyk użytkownika dotyczących jego osiągnięć</td>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td> 
        <td>api/system/achievement/me</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwrócenia osiągnięć, które użytkownik zdobył</td>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td> 
        <td>api/system/achievement/</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwrócenia wszystkich dostępnych osiągnięć</td>
    </tr>
    <tr>
        <td><span style="color:green ">GET</span></td> 
        <td>api/system/achievement/{achievement}</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwrócenia wybranego osiągnięcia [achievement] - id achievementu</td>
    </tr>
    <tr>
        <td><span style="color:orange">POST</span> </td> 
        <td>api/system/achievement/</td>
        <td><a title="wymagane, nazwa osiągnięcia">name</a>, <a title="wymagane, rodzaj osiągnięcia favourite/review/test">event_type</a>, <a title="wymagane, wartość wymagana do zdobycia osiągnięcia">value</a>, <a title="wymagane, wysokość nagrody">money</a></td>
        <td>admin</td>
        <td>Zapytanie służy do utworzenia nowego osiągnięcia</td>
    </tr>
    <tr>
        <td><span style="color:violet">PATCH</span></td> 
        <td>api/system/achievement/{achievement}</td>
        <td> <a title="wymagane, nazwa osiągnięcia">name</a>, <a title="wymagane, rodzaj osiągnięcia">event_type</a>, <a title="wymagane, wartość wymagana do zdobycia osiągnięcia">value</a>, <a title="wymagane, wysokość nagrody">money</a></td>
        <td>admin</td>
        <td>Zapytanie służy do aktualizacji jednego z osiągnięć [achievement] - id achievementu</td>
    </tr>
    <tr>
        <td><span style="color:red">DELETE</span></td> 
        <td>api/system/achievement/{achievement}</td>
        <td>-</td>
        <td>admin</td>
        <td>Zapytanie służy do usunięcia jednego z osiągnięć [achievement] - id achievementu</td>
    </tr>
    <tr>
        <td><span style="color:green">GET</span></td> 
        <td>api/system/daily_user_life/</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwracania informacji o życiach użytkownika</td>
    </tr>
    <tr>
        <td><span style="color:violet">PATCH</span> </td> 
        <td>api/system/daily_user_life/minus</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do odjęcia życia użytkownikowi po pomyłce w teście</td>
    </tr>
    <tr>
        <td><span style="color:violet">PATCH</span> </td> 
        <td>api/system/daily_user_life/plus</td>
        <td><a title = "wymagane, słówko po polsku">word_pl</a>, <a title = "wymagane, słówko po angielsku">word_en</a>, <a title = "wymagane, język słówka, które użytkownik otrzymał">langauge</a></td>
        <td>user</td>
        <td>Zapytanie służy do dodania serca wzamian za poprawne rozwiązanie zagadki</td>
    </tr>
    <tr>
        <td><span style="color:green">GET</span></td> 
        <td>api/system/streak/</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwracania informacji o wszystkich streakach użytkownika</td>
    </tr>
    <tr>
        <td><span style="color:green">GET</span></td> 
        <td>api/system/streak/latest</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwracania informacji o aktualnym streaku użytkownika</td>
    </tr>
    <tr>
        <td><span style="color:green">GET</span></td> 
        <td>api/system/streak/longest</td>
        <td>-</td>
        <td>user</td>
        <td>Zapytanie służy do zwracania informacji o najdłuższym streaku użytkownika</td>
    </tr>
    <tr>
        <td><span style="color:orange">POST</span></td> 
        <td>api/system/games/</td>
        <td><a title = "wymagane, typ gry, którą chcemy rozpocząć 15s/30s/60s">type</a></td>
        <td>user</td>
        <td>Zapytanie służy do rozpoczęcia gry czasowej o wybranym typie</td>
    </tr>
    <tr>
        <td><span style="color:orange">POST</span> </td> 
        <td>api/system/games/send</td>
        <td><a title = "wymagane, typ gry, którą chcemy rozpocząć 15s/30s/60s">type</a>, <a title = "wymagane, tłumaczenie słowka, które otrzymano jako ostatnie">word</a></td>
        <td>user</td>
        <td>Zapytanie służy do wysłania odpowiedzi na kolejne zadanie w grze czasowej</td>
    </tr>
    <tr>
        <td><span style="color:orange">POST</span> </td> 
        <td>api/system/games/history</td>
        <td><a title = "wymagane, typ gry, którą chcemy rozpocząć 15s/30s/60s">type</a></td>
        <td>user</td>
        <td>Zapytanie służy do zwrócenia historii gier użytkownika dla danego typu</td>
    </tr>
</table>
</details>


<br><br><br>
<h2>4.2 Scheduler</h2>
W projekcie zaimpementowaliśmy rozwiązanie nazywane Scheduler - czyli operacje cron. Jest to nic innego, jak specjalnie spreparowane funkcje, który wykonują się co określony czas, w określone dni, lub o określonej godzinie.<br>
Na serwerze wyróżniamy aktualnie dwa takie zdarzenia czasowe, jednak z czasem może ich przybyć więcej.<br>

- <b><u>Darmowe serduszko</u></b> - Co 2 godziny każdy z użytkowników, których liczba żyć nie przekracza 10, otrzymuje serduszko. Licznik czasu, odmierzający minuty do wykonania zdarzenia, umieszczony jest na dashboardzie, zatem każdy może sprawdzić, za ile może wykonać kolejną pomyłkę.<br>
- <b><u>Zmiana słówka dnia</u></b> - Codziennie o północy zmienia się słówko dnia i na dashboardzie ukazuje się nowo wybrany kafelek, dostępny przez następne, równe 24godziny.

Aby przetestować scheduler możemy zastosować niżej wymienione komendy:

- <b>php artisan schedule:list </b> - pokazuje listę wszystkich zadań oraz czas, za jaki planowane jest ich użycie.<br>
- <b>php artisan schedule:test </b> - pozwala przetestować wybrane przez nas zadanie. Wybieramy [0], aby wybrać nowe słowo dnia, lub [1] aby doładować każdemu z użytkowników 1 serduszko.<br>
- <b>php artisan schedule:work </b> - uruchomienie tej komendy powoduje wykonywanie zadań w określonym przez nas czasie.<br>

Przy testowaniu wyboru nowego słowa dnia, możemy napotkać się z problemem, że nie zostało ono zmienione. Należy wówczas zwolnić pamięć Cache naszego serwera, robimy to przy użyciu komendy:
- <b>php artisan Cache:clear</b>

Pod okoliczność zmiany słowa dnia, stworzona zpstała autorska komenda, za pomocą której możemy ręcznie zmienić słowo dnia z ominięciem schedulera:
- <b>php artisan pick</b>