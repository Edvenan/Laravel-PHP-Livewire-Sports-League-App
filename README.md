# League Management WebApp

## Introduction
This web app allows the user to follow a sports league (ranking, teams, calendar and games) as well as manage its key elements such as the teams and games.

## Architecture
The app has been developed using Laravel - PHP framework and following a MVC design pattern. \
The CRUD functions have been architectured as follows:

**Models:**
- User: model to handle the users
- Team: model to handle the Teams
- Games: model to handle the Games

**Controllers:**

In order to provide page reactivity, **livewire components** have been used to control the application, acting as controllers.
- ShowRanking
- ShowCalendar
- ShowGames (livewire component that includes Read, Edit and Delete for each register - no separate components have been developed in otder to gain page load and code length efficiency)
- CreateGame (separate livewire component for Create)
- ShowTeams (livewire component that includes Read, Edit and Delete for each register - no separate components have been developed in otder to gain page load and code length efficiency)
- CreateTeam (separate livewire component for Create)

**Views:**
- Show-Ranking
- Show-Calendar
- Show-Games
- Create-Game
- Show-Teams 
- Create-Team 
- 404 (error view)
- Database-Connection (error view)

<br>

## Functionality

This app supports 2 type of users (registered and unregistered) and the functionality availbale will depend on the type of user.

**Unregistered** users will be able to see:
- the league **ranking** and **teams statistics**
- the **teams information** (statistics, games)
- the league **calendar** and **game information**

**Registered** users, in addition to the above functionality, will be able to:
- **create**, **update** and **delete** teams
- **create**, **update** and **delete** games

To become a registered user, a username, password and email must be provided and the latter must be verified (email verification process). Once registered, the user can add his photo/avatar so that it is shown in the nav bar during the session. \
This app version comes with a pre-registered user:

- Email: defcon@one.com 
- Password: 1Laravel
- User's picture: stored in /resources/images/David_Lightman.jpg 

In order to be able to store the user's picture, the following steps must be followed in advance:
1) Delete 'storage' shortcut link from /public folder 
2) run 'php artisan storage:link' 
3) proceed to chose the user photo via the 'Manage Account' nav menu option.

<br>

**Creating Teams**

Registered users can create teams by indicating the following fields:

- **Required:** Name, Foundation Year (between 1850-2023) and Stadium
- **Not required:** emblem url (a default url will be used if not filled)

<br>

**Editing Teams**

Registered users are able to edit all the teams fields:  Name, Foundation Year (between 1850-2023), Emblem and Stadium.\
Changes in some of these fields (Name, Stadium, Emblem) will be cascaded to Games.

<br>

**Deleting Teams**

Registered users are able to delete teams. Deletion of a team will translate into:
- the deletion of all its games and into
- the revertion or undo of the resulting statistics of the games in the adversary teams (points, goals, games played, etc.).
To sum up, deleting a team is equivalent to as if the team never existed and that no other team has ever played against it.

<br>

**Creating Games**

Registered users can create games by indicating the following fields:

- **Required:** Local team, Visitor teams, game Date and Time. (The Stadium will be automatically populated with the local team's stadium)

<br>

**Editing Games**

Registered users are able to edit all teh following game fields: Local team, Visitor team, game Date and Time and both teams score.\
Teams scores will only be editable if the game Date is earlier than the actual editing date, that is if the edited game took place in the past. \
Therefore, if the game is planned to be played in the future, the score will not be editable.\
The Stadium cannot be edited as it will be automatically populated with the updated local team's stadium.

Changes in the game will be will be cascaded to the respective local and visitor teams' statistics.

Example: \
Team A plays Team B and Team A wins. That means that Team A statistics show 1 win and Team B's show 1 loss.\
We edit that game and make Team B the winner. The app will then revert the original result in both teams' statistics and apply the new score, resulting in Team A showing 1 loss and Team B 1 win.

<br>

**Deleting Games**

Registered users are able to delete a game. Deletion of a game will translate into the revertion or undo of the resulting statistics of the game in both local and visitor teams (points, goals, games played, etc.).\
To sum up, deleting a game is equivalent to as if the game between both local and visitor teams never took place.

<br>

**Statistics:**

When a team is created, its statistics are reset.\
When a team is updated, its statistics and its existing games (both past and future) are updated.\
When a team is deleted, its statistics are deleted and all adversary teams' statistics are updated accordingly.

Example: \
 Team A played Team B and they draw the game.\
 Team A got 1 point and Team B got 1 point.\
 When Team A is deleted, Team B's points are updated by substracting the 1 point won against Team A.

<br>

**Sorting by categories**

Users can order or sort the listing results of both the ranking and games list page by categories (or columns) and in both ascending and descending order, just by clicking on the corresponding column header.

<br>

**Search Bar**

By using the search bar, users will be able to filter and find games (by typing team names) and teams (by typing name, stadium name or foundation year).\
Sorting can also be applied to the search results.

<br>

 **Dynamic Pagination:**

All the app lists (ranking and games) are paginated and the user can select the number of items shown per page via a select element.\
Pagination is dynamic so there is no need to load the page every time we select a different page.

<br>

## Other features

**Dynamic input validation**

When creating and editing teams or games, all the inputs are dynamically validated, showing errors inmediately and before submiting the forms.

**Error Handling**

The app will show exceptions relative to Status Code 404 (Not found) and those relative to database connection issues.\
Any other exception will be shown by Laravel using the default 'develop' mode template.

**Defer Loading:**

Those wep app pages likely to manage a high number of records ('Teams' and 'Games') have been designed using defer loading.\
This allows to load the page quickly and to show at least the web page template while the records are being loaded, avoiding the user to think the page is hung.

**Team and User Seeder**

The Laravel project includes one **TeamSeeder** to automatically populate the database table 'Teams' with all the teams of the Spanish football 1st division league 2023-2024, as well as 3 addional teams from 2nd division.\
A **UserSeeder** is also included so that you don't need to go through the registration and email verification process.

**Games Factory**

The Laravel project includes also a **GameFactory** to automatically generate 30 random games between the any of the automatically created teams.\

Use the command "php artisan migrate:refresh --seed" to create the database and tables and to populate them.


## Technologies used
- **PHP & Laravel**: fullstack developmment framework
- **Jetstream**: application starter kit for Laravel. Provides login, registration, email verification, two-factor authentication, session management, API via Laravel Sanctum, and optional team management feature as well as a Livewire scaffolding.
- **Livewire**: allows for page reactivity, dynamic page capabilities and defer loading
- **Tailwind CSS**: allows for custom css styles
- **SweetAlert2**: js popups to give the user confirmations on actions completed or to ask for confirmation when deleting.
- **Alpine js**: used to build the calendar


## Useful links:

- [**Livewire pagination with Search and Sorting**](https://makitweb.com/create-livewire-pagination-with-search-filter-and-sorting-in-laravel/#create-component)
- [**Defer Loading**](https://laravel-livewire.com/docs/2.x/defer-loading)
- [**free Tailwind components**:]()\
      https://tailwindcomponents.com/component/calendar-ui-with-tailwindcss-and-alpinejs/landing \
      https://freefrontend.com/tailwind-spinners/ \
      https://v1.tailwindcss.com/components/alerts 
- [**Laravel Livewire update dependent select menu's on change**](https://www.youtube.com/watch?v=JXtZdnUv7IE)
- [**Laravel 9 JetStream Livewire CRUD Operations Tutorial**](https://medium.com/@laraveltuts/laravel-9-jetstream-livewire-crud-operations-tutorial-628e4783cce2)
- [**Mailtrap**](https://mailtrap.io/signin)
