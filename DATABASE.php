-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8mb4 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Artikel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Artikel` (
  `idArtikel` INT(11) NOT NULL AUTO_INCREMENT,
  `naam` VARCHAR(45) NULL DEFAULT NULL,
  `type` VARCHAR(45) NULL DEFAULT NULL,
  `fabriek` VARCHAR(45) NULL DEFAULT NULL,
  `waarde_inkoop` DECIMAL(10,0) NULL DEFAULT NULL,
  `waarde_verkoop` DECIMAL(10,0) NULL DEFAULT NULL,
  PRIMARY KEY (`idArtikel`))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`Locatie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Locatie` (
  `idLocatie` INT(11) NOT NULL AUTO_INCREMENT,
  `locatieNaam` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idLocatie`))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`Bestelling`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Bestelling` (
  `idBestelling` INT(11) NOT NULL AUTO_INCREMENT,
  `idLocatie` INT(11) NOT NULL,
  `BestelDatum` DATE NULL DEFAULT NULL,
  `LeverDatum` DATE NULL DEFAULT NULL,
  `Afgelevered` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idBestelling`),
  INDEX `fk_Bestelling_Locatie1_idx` (`idLocatie` ASC) VISIBLE,
  CONSTRAINT `fk_Bestelling_Locatie1`
    FOREIGN KEY (`idLocatie`)
    REFERENCES `mydb`.`Locatie` (`idLocatie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`Bestelling_has_Artikel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Bestelling_has_Artikel` (
  `Bestelling_idBestelling` INT(11) NOT NULL,
  `Artikel_idArtikel` INT(11) NOT NULL,
  `aantal` DECIMAL(10,0) NULL DEFAULT NULL,
  PRIMARY KEY (`Bestelling_idBestelling`, `Artikel_idArtikel`),
  INDEX `fk_Bestelling_has_Artikel_Artikel1_idx` (`Artikel_idArtikel` ASC) VISIBLE,
  INDEX `fk_Bestelling_has_Artikel_Bestelling_idx` (`Bestelling_idBestelling` ASC) VISIBLE,
  CONSTRAINT `fk_Bestelling_has_Artikel_Artikel1`
    FOREIGN KEY (`Artikel_idArtikel`)
    REFERENCES `mydb`.`Artikel` (`idArtikel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Bestelling_has_Artikel_Bestelling`
    FOREIGN KEY (`Bestelling_idBestelling`)
    REFERENCES `mydb`.`Bestelling` (`idBestelling`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `mydb`.`Voorraad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Voorraad` (
  `idLocatie` INT(11) NOT NULL,
  `idArtikel` INT(11) NOT NULL,
  `aantal` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idLocatie`, `idArtikel`),
  INDEX `fk_Locatie_has_Artikel_Artikel1_idx` (`idArtikel` ASC) VISIBLE,
  INDEX `fk_Locatie_has_Artikel_Locatie1_idx` (`idLocatie` ASC) VISIBLE,
  CONSTRAINT `fk_Locatie_has_Artikel_Artikel1`
    FOREIGN KEY (`idArtikel`)
    REFERENCES `mydb`.`Artikel` (`idArtikel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Locatie_has_Artikel_Locatie1`
    FOREIGN KEY (`idLocatie`)
    REFERENCES `mydb`.`Locatie` (`idLocatie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
