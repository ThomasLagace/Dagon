-- Make the utilizers table. This is where users will be stored.

CREATE TABLE utilizers (
    id serial PRIMARY KEY,
    login varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    name varchar(255) DEFAULT NULL, --The user should be able to change their name.
    lvl int NOT NULL -- How powerful the user is. Some php file'll detail it, I guess. 
);

-- Blog content go here.
CREATE TABLE posts (
    id serial PRIMARY KEY,
    title varchar(255) NOT NULL,
    body varchar NOT NULL,
    tags varchar DEFAULT NULL
);

-- In theory, you should have a unique commentid for every postid.
-- This will allow us to keep track of comments per post.
CREATE TABLE comments (
    postid int4 NOT NULL,
    commentid int4 NOT NULL,
    title varchar(255) DEFAULT NULL,
    body varchar NOT NULL,
    userid int4 NOT NULL
);

-- This table's for signin' up n stuff lmao
CREATE TABLE invites (
    id serial PRIMARY KEY,
    code varchar(255) NOT NULL,
    used boolean DEFAULT FALSE,
    lvl int NOT NULL,
    usedby varchar(255) default NULL
);
