DROP DATABASE IF EXISTS chat;
CREATE DATABASE IF NOT EXISTS chat;

USE chat;

CREATE TABLE IF NOT EXISTS utilisateurs(
	utilisateur_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL, 
	utilisateur_pseudo VARCHAR(25) NOT NULL,
	utilisateur_mdp VARCHAR(60) NOT NULL
) Engine=InnoDB;

CREATE TABLE IF NOT EXISTS messages(
	message_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL, 
	message_txt TEXT NOT NULL,
	message_date DATETIME NOT NULL,
	id_utilisateur INT NOT NULL,
	FOREIGN KEY (id_utilisateur) references utilisateurs(utilisateur_id)
) Engine=InnoDB;