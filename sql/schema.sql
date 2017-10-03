-- Make the utilizers table. This is where users will be stored.

CREATE TABLE utilizers (
    id serial PRIMARY KEY,
    login varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    name varchar(255) DEFAULT NULL, --The user should be able to change their name.
    lvl int NOT NULL, -- How powerful the user is. Some php file'll detail it, I guess.
    creation_date date NOT NULL,
    avatar varchar
);

-- Blog content go here.
CREATE TABLE posts (
    id serial PRIMARY KEY,
    author varchar(255) NOT NULL,
    creation_date date NOT NULL,
    title varchar(255) NOT NULL,
    body varchar NOT NULL,
    tags varchar DEFAULT NULL,
    deleted boolean DEFAULT FALSE,
    hidden boolean DEFAULT FALSE
);

-- In theory, you should have a unique commentid for every postid.
-- This will allow us to keep track of comments per post.
CREATE TABLE comments (
    id serial PRIMARY KEY,
    postid int4 NOT NULL,
    commentid int4 NOT NULL, --For replies
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
