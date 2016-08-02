-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema teste
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema teste
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `teste` DEFAULT CHARACTER SET utf8 ;
USE `teste` ;

-- -----------------------------------------------------
-- Table `teste`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teste`.`User` (
  `email` VARCHAR(70) NOT NULL,
  `userName` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`email`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`Project`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teste`.`Project` (
  `NameProject` VARCHAR(45) NOT NULL,
  `StartDate` DATE NOT NULL,
  `EndDate` DATE NOT NULL,
  `productOwner` VARCHAR(45) NOT NULL,
  `projectManager` VARCHAR(45) NOT NULL,
  `Description` VARCHAR(500) NULL,
  `User_email` VARCHAR(70) NOT NULL,
  PRIMARY KEY (`NameProject`, `User_email`),
  INDEX `fk_Project_User1_idx` (`User_email` ASC),
  CONSTRAINT `fk_Project_User1`
    FOREIGN KEY (`User_email`)
    REFERENCES `teste`.`User` (`email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`Team`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teste`.`Team` (
  `idTeam` INT NOT NULL,
  `productOwner` VARCHAR(45) NOT NULL,
  `scrumMaster` VARCHAR(45) NULL,
  `Project_NameProject` VARCHAR(45) NOT NULL,
  `Project_User_email` VARCHAR(70) NOT NULL,
  PRIMARY KEY (`idTeam`, `Project_NameProject`, `Project_User_email`),
  INDEX `fk_Team_Project1_idx` (`Project_NameProject` ASC, `Project_User_email` ASC),
  CONSTRAINT `fk_Team_Project1`
    FOREIGN KEY (`Project_NameProject` , `Project_User_email`)
    REFERENCES `teste`.`Project` (`NameProject` , `User_email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`Sprint`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teste`.`Sprint` (
  `idSprint` INT NOT NULL,
  `sprintStatus` VARCHAR(45) NULL,
  `Project_NameProject` VARCHAR(45) NOT NULL,
  `Project_User_email` VARCHAR(70) NOT NULL,
  PRIMARY KEY (`idSprint`, `Project_NameProject`, `Project_User_email`),
  INDEX `fk_Sprint_Project1_idx` (`Project_NameProject` ASC, `Project_User_email` ASC),
  CONSTRAINT `fk_Sprint_Project1`
    FOREIGN KEY (`Project_NameProject` , `Project_User_email`)
    REFERENCES `teste`.`Project` (`NameProject` , `User_email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`ProductBacklog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teste`.`ProductBacklog` (
  `productBacklogcolItem` VARCHAR(45) NOT NULL,
  `statusProductBacklog` VARCHAR(45) NOT NULL,
  `ProductBacklogcologDescription` VARCHAR(245) NULL,
  `PlanningPoker` INT NULL,
  `productBacklogDate` DATE NULL,
  `Project_NameProject` VARCHAR(45) NOT NULL,
  `Project_User_email` VARCHAR(70) NOT NULL,
  `Sprint_idSprint` INT NULL,
  INDEX `fk_ProductBacklog_Project1_idx` (`Project_NameProject` ASC, `Project_User_email` ASC),
  PRIMARY KEY (`productBacklogcolItem`, `Project_NameProject`, `Project_User_email`),
  INDEX `fk_ProductBacklog_Sprint1_idx` (`Sprint_idSprint` ASC),
  CONSTRAINT `fk_ProductBacklog_Project1`
    FOREIGN KEY (`Project_NameProject` , `Project_User_email`)
    REFERENCES `teste`.`Project` (`NameProject` , `User_email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ProductBacklog_Sprint1`
    FOREIGN KEY (`Sprint_idSprint`)
    REFERENCES `teste`.`Sprint` (`idSprint`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`DevelopmentTeam`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teste`.`DevelopmentTeam` (
  `name` VARCHAR(50) NOT NULL,
  `cargo` VARCHAR(45) NULL,
  `Team_idTeam` INT NOT NULL,
  INDEX `fk_DevelopmentTeam_Team1_idx` (`Team_idTeam` ASC),
  PRIMARY KEY (`Team_idTeam`, `name`),
  CONSTRAINT `fk_DevelopmentTeam_Team1`
    FOREIGN KEY (`Team_idTeam`)
    REFERENCES `teste`.`Team` (`idTeam`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`Employee`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teste`.`Employee` (
  `employeeEmail` VARCHAR(45) NOT NULL,
  `employeeName` VARCHAR(45) NOT NULL,
  `employeeFunction` VARCHAR(45) NULL,
  `limiteProjetos` INT NOT NULL,
  `User_email` VARCHAR(70) NOT NULL,
  `Project_NameProject` VARCHAR(45) NULL,
  INDEX `fk_table1_User1_idx` (`User_email` ASC),
  PRIMARY KEY (`employeeEmail`, `User_email`),
  INDEX `fk_Employee_Project1_idx` (`Project_NameProject` ASC),
  CONSTRAINT `fk_table1_User1`
    FOREIGN KEY (`User_email`)
    REFERENCES `teste`.`User` (`email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Employee_Project1`
    FOREIGN KEY (`Project_NameProject`)
    REFERENCES `teste`.`Project` (`NameProject`)
    ON DELETE SET NULL
    ON UPDATE SET NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`BugTraker`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teste`.`BugTraker` (
  `idBugTraker` VARCHAR(45) NOT NULL,
  `Sprint_idSprint` INT NOT NULL,
  `BugTraker_Description` VARCHAR(245) NOT NULL,
  `BugTraker_User` VARCHAR(45) NOT NULL,
  `BugTraker_Status` VARCHAR(45) NOT NULL,
  `ProductBacklog_productBacklogcolItem` VARCHAR(45) NOT NULL,
  `ProductBacklog_Project_NameProject` VARCHAR(45) NOT NULL,
  `ProductBacklog_Project_User_email` VARCHAR(70) NOT NULL,
  PRIMARY KEY (`idBugTraker`, `ProductBacklog_Project_User_email`, `ProductBacklog_Project_NameProject`, `ProductBacklog_productBacklogcolItem`, `Sprint_idSprint`),
  INDEX `fk_BugTraker_Sprint1_idx` (`Sprint_idSprint` ASC),
  INDEX `fk_BugTraker_ProductBacklog1_idx` (`ProductBacklog_productBacklogcolItem` ASC, `ProductBacklog_Project_NameProject` ASC, `ProductBacklog_Project_User_email` ASC),
  CONSTRAINT `fk_BugTraker_Sprint1`
    FOREIGN KEY (`Sprint_idSprint`)
    REFERENCES `teste`.`Sprint` (`idSprint`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_BugTraker_ProductBacklog1`
    FOREIGN KEY (`ProductBacklog_productBacklogcolItem` , `ProductBacklog_Project_NameProject` , `ProductBacklog_Project_User_email`)
    REFERENCES `teste`.`ProductBacklog` (`productBacklogcolItem` , `Project_NameProject` , `Project_User_email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`Meeting`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `teste`.`Meeting` (
  `idMeeting` VARCHAR(45) NOT NULL,
  `Project_NameProject` VARCHAR(45) NOT NULL,
  `Project_User_email` VARCHAR(70) NOT NULL,
  `Meeting_Description` VARCHAR(70) NOT NULL,
  `Meeting_Date` DATE NOT NULL,
  `MeetingMember` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idMeeting`, `Project_NameProject`, `Project_User_email`, `Meeting_Date`, `MeetingMember`),
  INDEX `fk_Meeting_Project1_idx` (`Project_NameProject` ASC, `Project_User_email` ASC),
  CONSTRAINT `fk_Meeting_Project1`
    FOREIGN KEY (`Project_NameProject` , `Project_User_email`)
    REFERENCES `teste`.`Project` (`NameProject` , `User_email`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
