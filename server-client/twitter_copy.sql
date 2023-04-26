CREATE TABLE users (
  email varchar(255) NOT NULL,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  first_name varchar(255) DEFAULT NULL,
  last_name varchar(255) DEFAULT NULL,
  bio text DEFAULT NULL,
  isAdmin tinyint(1) DEFAULT 0,
  PRIMARY KEY (username),
);

CREATE TABLE follows (
  username varchar(255) NOT NULL,
  follower_username varchar(255) NOT NULL,
  PRIMARY KEY (follower_username, username),
  FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE,
  FOREIGN KEY (follower_username) REFERENCES users(username) ON DELETE CASCADE
);

CREATE TABLE tweets (
  tweet_id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  text text NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (tweet_id),
  FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE
);

CREATE TABLE likes (
  username varchar(255) NOT NULL,
  tweet_id int(11) NOT NULL,
  PRIMARY KEY (username, tweet_id),
  FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE,
  FOREIGN KEY (tweet_id) REFERENCES tweets(tweet_id) ON DELETE CASCADE
);