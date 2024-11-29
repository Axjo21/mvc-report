
# Scrutinizer Badges:

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Axjo21/mvc-report/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/Axjo21/mvc-report/?branch=main)

[![Code Coverage](https://scrutinizer-ci.com/g/Axjo21/mvc-report/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/Axjo21/mvc-report/?branch=main)

[![Build Status](https://scrutinizer-ci.com/g/Axjo21/mvc-report/badges/build.png?b=main)](https://scrutinizer-ci.com/g/Axjo21/mvc-report/build-status/main)

[![Code Intelligence Status](https://scrutinizer-ci.com/g/Axjo21/mvc-report/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)


# Starting the repository locally:

### Clone git repo using SSH-key:
` git clone git@github.com:Axjo21/mvc-report.git `

### Install dependencies:
` composer --version `
` composer install `

### Start the application:
` php -S localhost:9001 -t public `

### You may also access the application at the following url:
` http://www.student.bth.se/~axjo21/dbwebb-kurser/mvc/me/report/public/`


# About the repository:
This repo was created by Axel Jönsson (axjo21) as a part of a course as part of the Webbprogrammering program at Blekinge Tekniska Högskola, Sweden. 
The main subject of the course was to learn about the Model View Controller (MVC) architectural design pattern, with focus on the Model-part (writing object-oriented code). For this purpose we wrote our code in PHP, using Symfony as our framework.
The application is divided into different parts, each part serving as a mini-project. You can find these parts of the application through the navbar. They involve things such as a card game, a json-api, a "library" where CRUD interactions with an ORM-database are made possible, and lastly the final project for the course; a Black Jack game. 
The Black Jack game let's you register 1-3 players, place bets, draw or hold cards and compete with the Bank. 
The players and bank are stored in a linked list called PlayerQueue, each party being a node inside the linked list. The class CardHand (or BankHand) are saved to the Nodes data, thus allowing us to make use of previously established classes while building upon that functionality through the new Node and PlayerQueue classes. 

#### All code in the MVC related files are written by me, Axel Jönsson. I make no claim to having created any of the dependencies that the repo makes use of.
