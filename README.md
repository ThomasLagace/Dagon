INTRODUCTION
============
Why am I making this?
---------------------
I really just want a personal blogging site to use. That's 'bout it.

This project has actually been discontinued. It was mostly also made
to learn about backend website development. I will likely remake this
site with a better UI in a real framework soon.

Features
--------
You can:
* View blog posts
* Make blog posts (incredible!)
* Edit blog posts? Later?
* Write blog posts in beautiful markdown courtesy of [Parsedown](https://github.com/erusev/parsedown/ "parsedown")

It has:
* Code highlighting courtesy of [highlight.js](https://highlightjs.org/ "highlight.js")

What do I need on the server / client side?
-------------------------------------------
I don't really know if it'll work with anything else, but I'm using
* An Apache webserver
* PHP 7
* PostgreSQL

STANDARDS FOR (ME) YOU
=======================

Directory Structure
-------------------
*Note that this is a bit outdated*
```
├── sql                 -- Database stuff go here
└── web                 -- $DOCROOT
    ├── assets          -- Client-side prettiness
    │   ├── css
    │   ├── img
    │   │   └── user    -- User submitted images
    │   ├── js 
    │   └── templates   -- Templates for different parts of the site
    ├── includes        -- Backend code
    └── vendor          -- Composer-installed packages
```
This is all subject to change

TODO
====
* Code cleanup, objectify many parts to make it more maintainable
* Make it look pretty
* Make posts editable / deletable
* Allow for custom images to be uploaded
