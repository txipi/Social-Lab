Social-Lab
==========

Social Lab is NOT a real social network. It is a social engineering wargame.

Social Lab mimics the features of a basic social network (i.e., friendship requests, status updates, private messages, pictures, fan pages, etc.) to provide a "social sandbox".

The purpose of the game is to learn some of the techniques used by social hackers in order to prevent this kind of attacks in real social networks.

How to play
===========

- Create an account
- Sign in
- Wait for a message from the system explaining what is your next challenge as a social hacker ;)

Important tips:
- Every challenge will be controlled by an automated profile (no real people privacy is invaded playing Social Lab).
- These profiles must be convinced to become your friends using your social engineering skills.
- Their responses are automatic but not immediate. Sometimes they need a few minutes to realize that you look friendly enough to become their friend ;-)

What is Social Engineering?
===========================

Social engineering, in the context of security, is understood to mean the art of manipulating people into performing actions or divulging confidential information. While it is similar to a confidence trick or simple fraud, it is typically trickery or deception for the purpose of information gathering, fraud, or computer system access; in most cases the attacker never comes face-to-face with the victims.

Social engineering as an act of psychological manipulation had previously been associated with the social sciences, but its usage has caught on among computer professionals.

What is a wargame?
==================

A wargame in hacking is a security challenge in which one must exploit a vulnerability in a system or application or gain access to a system.


License
=======

Social Lab is free software.

Social Lab code is released under a free software license (Affero General Publice License version 3).

Images of fake profiles provided by Social Lab are property of David Niblack and released under a Creative Commons Attribution 3.0 license.

Social Lab's Terms of Use are partially based on Creative Commons Terms of Use.


Install your own Social Lab
===========================

Requirements
------------

To install your own instance of Social Lab your need to fulfill the following requirements:
- A PHP 5 compliant web server (e.g., Apache, Lighttpd, IIS, etc.)
- A Symfony compatible database server (e.g., MySQL, PostgreSQL, etc.)
- Optional (but very recommended): a network connection for multiplayer gaming.

Database setup
--------------

- Create the database:

    CREATE DATABASE social;

- Create a user with privileges:

    GRANT ALL ON social.* TO 'social'@'localhost' IDENTIFIED BY 'YOURpassword';


Install Social Lab
------------------

- Download a tarball and unzip it or clone Social Lab repository to get the code.
- Set up your web server to provide access to Social Lab /web directory.
- Populate your database using Social Lab data fixtures:
    php symfony propel:data-load
- Set up an scheduled task (via cron) to call Social Lab's Task Scheduler:
    crontab -e
    */5 * * * *	/usr/bin/lynx --dump http://yoursociallab.org/default/scheduler

Define new automated profiles
=============================

Scheduled tasks
---------------

Each time a friend request is sent, Social Lab checks if there is an automated profile involved (also known as bots). If that is the case, Social Lab creates a new scheduled task. Scheduled tasks are processed periodically by the Task Scheduler. Therefore, the interactions of automated profiles are not immediate.

Each scheduled task is defined by the following parameters:
- From: The user profile of the automated profile involved.
- To: The user profile of the player involved.
- Step: The current step in the automated procedure (0, 1, 2, etc.).
- Status: The status of the scheduled task (pending or accepted).

Bots, steps, commands & automsgs
--------------------------------

To program an automated profile the following steps must be done:
- Add a new row to the Bot table, defining the ID of an existing profile and a short description.
- Define the behavior of the automated profile using the commands provided by the Command table (e.g., Send Message, Check Request, Accept Friendship, etc.).
- If the commands needed to define the behavior of the bot need messages, define them as rows in the Automsg table.
- Add new rows to the Step table, defining the bot involved, the command that has to process, the step order and an optional message (reference to a row in Automsg table)

Examples
--------

The simplest example, an "always accept" bot:
- Add a new row to the Bot table: id = B, user = 30, description = 'Always accept bot'.
- Define the behavior: Accept Friendship.
- Add new rows to the Step table: bot = B, command = Accept Friendship, step order = 0, automsg = null.

A more complex example:
- Add a new row to the Bot table: id = B, user = 23, description = 'Check location bot'.
- Define the behavior: Send Message ('Are you from my home town?') > Check location > Accept Friendship.
- One step of the bot's behavior involves a message. Therefore, add a new row to the Automsg table: text = 'Are you from my home town?', id = M, user = null (no user profile involved in this message).
- Add new rows to the Step table:
 -  bot = B, command = Send Message, step order = 0, automsg = M.
 -  bot = B, command = Check Location, step order = 1, automsg = null.
 -  bot = B, command = Accept Friendship, step order = 2, automsg = null.

