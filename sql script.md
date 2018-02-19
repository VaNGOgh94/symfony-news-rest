
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0; 
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0; 
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES'; 


DROP SCHEMA IF EXISTS `civcija_task_db` ; 

CREATE SCHEMA IF NOT EXISTS `civcija_task_db` ; USE `civcija_task_db` ; 

DROP TABLE IF EXISTS `civcija_task_db`.`topic` ; 
CREATE TABLE IF NOT EXISTS `civcija_task_db`.`topic` 
( `id` INT NOT NULL AUTO_INCREMENT, `title` VARCHAR(100) NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8; 


DROP TABLE IF EXISTS `civcija_task_db`.`article` ;
CREATE TABLE IF NOT EXISTS `civcija_task_db`.`article` 
( `id` INT NOT NULL AUTO_INCREMENT, `title` VARCHAR(100) NOT NULL, `author` VARCHAR(60) NOT NULL, `text` TEXT NOT NULL, `topic_id` INT NOT NULL, PRIMARY KEY (`id`, `topic_id`), INDEX `fk_article_topic_idx` (`topic_id` ASC), CONSTRAINT `fk_article_topic` FOREIGN KEY (`topic_id`) REFERENCES `civcija_task_db`.`topic` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8; 
SET SQL_MODE=@OLD_SQL_MODE; SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS; SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS; 


INSERT INTO topic (title) VALUES
	("Sci-Fi"),
	("Politics"),
	("Health");

INSERT INTO article (title, author, text, topic_id) VALUES 
	("In 'Arrival', the World Is Saved by Words", "Anna North", "A woman stands inside a spaceship. Only a glass-like partition separates her from two enormous aliens. The woman removes her biohazard suit. She approaches the aliens. She presses her palm against the partition. This is what heroism looks like in Arrival.", 1),
	("Diplomats in Cuba Suffered Brain Injuries. Experts Still Don't Know Why.", "Gina Kolata", "A group of American diplomats stationed in Havana appear to have symptoms of concussion without ever having received blows to their heads, medical experts have found.

The diplomats originally were said to have been victims of a sonic attack, a possibility that the Federal Bureau of Investigation reportedly ruled out in January.", 2),
	("U.S. Bank Cited by Federal Authorities for Lapses on Money Laundering", "Emily Flitter", "U.S. Bank, the fifth-largest commercial bank by assets in the United States, was charged by the federal authorities on Thursday with failing to guard against illegal activity and, in at least one instance, even abetting it.

The Justice Department accused U.S. Bank, which is based in Minneapolis, of severely neglecting anti-money laundering rules, helping a payday lender operate an illegal business and lying to a regulator about its plans for tracking potential criminal activity by bank customers.", 2),
	("Frustration Grows as Congress Shows Inability to Pass Even Modest Gun Measures", "Nicholas Fandos and Thomas Kaplan", "WASHINGTON — After a gunman in Las Vegas slaughtered country-music fans with assault weapons that mimicked a machine gun, lawmakers from both parties said they would move quickly to ban so-called bump stocks.", 2),
	("A Cancer Researcher Takes Cancer Personally", "Susan Gubar", "Ongoing breakthroughs in cancer care involve personalized medicine, we are often informed. Because every malignancy is unique in terms of its genetics and genomics, one size (or protocol) cannot fit all.", 3),
	("Obesity Tied to Survival in Men With Melanoma", "Nicholas Bakalar", "Obese men treated for metastatic melanoma may survive longer than their normal-weight peers.", 3);

