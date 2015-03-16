SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `cantorix_archive` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `cantorix_archive` ;

-- -----------------------------------------------------
-- Table `cantorix_archive`.`cpn_subscription_plans`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`cpn_subscription_plans` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `type` VARCHAR(155) NOT NULL ,
  `validity` VARCHAR(45) NULL ,
  `no_of_staffs` SMALLINT NULL ,
  `no_of_clients` INT NULL ,
  `no_of_invoices` BIGINT NULL ,
  `cost` FLOAT NOT NULL ,
  `deletion_days` TINYINT NULL ,
  `archieve_days` TINYINT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`cpn_currencies`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`cpn_currencies` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `code` VARCHAR(15) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`cpn_languages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`cpn_languages` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `language` VARCHAR(55) NULL ,
  `iso_code` VARCHAR(55) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`cpn_financial_years`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`cpn_financial_years` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `from_month` ENUM('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec') NULL ,
  `to_month` ENUM('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec') NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`sbs_subscriber_organization_details`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`sbs_subscriber_organization_details` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `organization_name` VARCHAR(255) NOT NULL ,
  `billing_address_line1` TEXT NULL ,
  `billing_address_line2` TEXT NULL ,
  `billing_city` VARCHAR(25) NULL ,
  `billing_state` VARCHAR(25) NULL ,
  `billing_country` VARCHAR(45) NULL ,
  `billing_zip` VARCHAR(45) NULL ,
  `shiping_address_line1` TEXT NULL ,
  `shipping_address_line2` TEXT NULL ,
  `shipping_city` VARCHAR(25) NULL ,
  `shipping_state` VARCHAR(25) NULL ,
  `shipping_country` VARCHAR(45) NULL ,
  `shipping_zip` VARCHAR(45) NULL ,
  `website` VARCHAR(255) NULL ,
  `phone` VARCHAR(20) NULL ,
  `fax` VARCHAR(45) NULL ,
  `time_zone` VARCHAR(155) NULL ,
  `logo` VARCHAR(255) NULL ,
  `cpn_currency_id` INT NOT NULL ,
  `cpn_language_id` INT NOT NULL ,
  `cpn_financial_year_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_sbs_subscriber_organization_details_cpn_currencies1` (`cpn_currency_id` ASC) ,
  INDEX `fk_sbs_subscriber_organization_details_cpn_languages1` (`cpn_language_id` ASC) ,
  INDEX `fk_sbs_subscriber_organization_details_cpn_financial_years1` (`cpn_financial_year_id` ASC) ,
  CONSTRAINT `fk_sbs_subscriber_organization_details_cpn_currencies1`
    FOREIGN KEY (`cpn_currency_id` )
    REFERENCES `cantorix_archive`.`cpn_currencies` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sbs_subscriber_organization_details_cpn_languages1`
    FOREIGN KEY (`cpn_language_id` )
    REFERENCES `cantorix_archive`.`cpn_languages` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sbs_subscriber_organization_details_cpn_financial_years1`
    FOREIGN KEY (`cpn_financial_year_id` )
    REFERENCES `cantorix_archive`.`cpn_financial_years` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`sbs_subscribers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`sbs_subscribers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(155) NULL ,
  `surname` VARCHAR(155) NULL ,
  `subscribed_date` DATE NULL ,
  `home_phone` VARCHAR(45) NULL ,
  `mobile` VARCHAR(45) NULL ,
  `status` ENUM('Active','Inactive','Pending') NULL ,
  `cpn_subscription_plan_id` INT NOT NULL ,
  `sbs_subscriber_organization_detail_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_subscribers_cpn_subscription_plans1` (`cpn_subscription_plan_id` ASC) ,
  INDEX `fk_subscribers_sbs_subscriber_organization_details1` (`sbs_subscriber_organization_detail_id` ASC) ,
  CONSTRAINT `fk_subscribers_cpn_subscription_plans1`
    FOREIGN KEY (`cpn_subscription_plan_id` )
    REFERENCES `cantorix_archive`.`cpn_subscription_plans` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_subscribers_sbs_subscriber_organization_details1`
    FOREIGN KEY (`sbs_subscriber_organization_detail_id` )
    REFERENCES `cantorix_archive`.`sbs_subscriber_organization_details` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acr_clients`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acr_clients` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `client_no` VARCHAR(50) NOT NULL ,
  `client_name` VARCHAR(255) NOT NULL ,
  `billing_address_line1` TEXT NULL ,
  `billing_address_line2` TEXT NULL ,
  `billing_city` VARCHAR(25) NULL ,
  `billing_state` VARCHAR(25) NULL ,
  `billing_country` VARCHAR(45) NULL ,
  `billing_zip` VARCHAR(45) NULL ,
  `shiping_address_line1` TEXT NULL ,
  `shipping_address_line2` TEXT NULL ,
  `shipping_city` VARCHAR(25) NULL ,
  `shipping_state` VARCHAR(25) NULL ,
  `shipping_country` VARCHAR(45) NULL ,
  `shipping_zip` VARCHAR(45) NULL ,
  `website` VARCHAR(255) NULL ,
  `business_phone` VARCHAR(20) NULL ,
  `business_fax` VARCHAR(45) NULL ,
  `notes` TEXT NULL ,
  `status` ENUM('active','Inactive') NULL ,
  `send_invoice_by` ENUM('email','snail_mail','others') NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  `cpn_currency_id` INT NOT NULL ,
  `cpn_language_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_acr_clients_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  INDEX `fk_acr_clients_cpn_currencies1` (`cpn_currency_id` ASC) ,
  INDEX `fk_acr_clients_cpn_languages1` (`cpn_language_id` ASC) ,
  CONSTRAINT `fk_acr_clients_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acr_clients_cpn_currencies1`
    FOREIGN KEY (`cpn_currency_id` )
    REFERENCES `cantorix_archive`.`cpn_currencies` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acr_clients_cpn_languages1`
    FOREIGN KEY (`cpn_language_id` )
    REFERENCES `cantorix_archive`.`cpn_languages` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acr_client_custom_fields`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acr_client_custom_fields` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `field_name` VARCHAR(255) NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_acr_client_custom_fields_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_acr_client_custom_fields_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acr_client_custom_values`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acr_client_custom_values` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data` VARCHAR(255) NULL ,
  `acr_client_id` INT NOT NULL ,
  `acr_client_custom_field_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_client_custom_values_acr_clients1` (`acr_client_id` ASC) ,
  INDEX `fk_client_custom_values_acr_client_custom_fields1` (`acr_client_custom_field_id` ASC) ,
  CONSTRAINT `fk_client_custom_values_acr_clients1`
    FOREIGN KEY (`acr_client_id` )
    REFERENCES `cantorix_archive`.`acr_clients` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_client_custom_values_acr_client_custom_fields1`
    FOREIGN KEY (`acr_client_custom_field_id` )
    REFERENCES `cantorix_archive`.`acr_client_custom_fields` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acr_client_contacts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acr_client_contacts` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(155) NOT NULL ,
  `sur_name` VARCHAR(155) NOT NULL ,
  `email` VARCHAR(155) NOT NULL ,
  `mobile` VARCHAR(45) NULL ,
  `home_phone` VARCHAR(45) NULL ,
  `work_phone` VARCHAR(45) NULL ,
  `is_primary` ENUM('Y','N') NOT NULL DEFAULT 'N' ,
  `acr_client_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_client_contacts_acr_clients1` (`acr_client_id` ASC) ,
  CONSTRAINT `fk_client_contacts_acr_clients1`
    FOREIGN KEY (`acr_client_id` )
    REFERENCES `cantorix_archive`.`acr_clients` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`sls_quotations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`sls_quotations` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `quotation_no` VARCHAR(45) NOT NULL ,
  `exchange_rate` FLOAT NULL DEFAULT 1.0 ,
  `description` VARCHAR(255) NULL ,
  `issue_date` DATE NULL ,
  `purchase_order_no` INT NULL ,
  `expiry_date` DATE NULL ,
  `status` ENUM('Draft','Open','Invoiced') NULL ,
  `notes` TEXT NULL ,
  `sub_total` DOUBLE NULL ,
  `tax_total` DOUBLE NULL ,
  `func_estimate_total` DOUBLE NULL COMMENT 'Application currency total' ,
  `acr_client_id` INT NOT NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  `invoice_amount` DOUBLE NULL COMMENT 'Client currency total' ,
  `invoice_currency_code` VARCHAR(15) NULL COMMENT 'Client currency code' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_quotations_acr_clients1` (`acr_client_id` ASC) ,
  INDEX `fk_sls_quotations_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_quotations_acr_clients1`
    FOREIGN KEY (`acr_client_id` )
    REFERENCES `cantorix_archive`.`acr_clients` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sls_quotations_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`inv_inventories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`inv_inventories` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(155) NULL ,
  `description` TEXT NULL ,
  `list_price` DOUBLE NULL ,
  `track_quantity` ENUM('Y','N') NULL ,
  `current_stock` INT NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_inv_inventories_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_inv_inventories_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`sbs_subscriber_taxes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`sbs_subscriber_taxes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `code` VARCHAR(15) NOT NULL ,
  `percent` TINYINT NOT NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_subscriber_taxes_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_subscriber_taxes_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`sbs_subscriber_tax_groups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`sbs_subscriber_tax_groups` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `group_name` VARCHAR(45) NOT NULL ,
  `compounded` ENUM('Y','N') NOT NULL DEFAULT 'N' ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_subscriber_tax_groups_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_subscriber_tax_groups_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`sls_quotation_products`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`sls_quotation_products` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `quantity` INT NOT NULL DEFAULT 1 ,
  `unit_rate` DOUBLE NOT NULL ,
  `discount_percent` TINYINT NULL ,
  `line_total` DOUBLE NOT NULL ,
  `sls_quotation_id` INT NOT NULL ,
  `inv_inventory_id` INT NOT NULL ,
  `sbs_subscriber_tax_id` INT NOT NULL ,
  `sbs_subscriber_tax_group_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_quotation_products_sls_quotations1` (`sls_quotation_id` ASC) ,
  INDEX `fk_sls_quotation_products_inv_inventories1` (`inv_inventory_id` ASC) ,
  INDEX `fk_sls_quotation_products_sbs_subscriber_taxes1` (`sbs_subscriber_tax_id` ASC) ,
  INDEX `fk_sls_quotation_products_sbs_subscriber_tax_groups1` (`sbs_subscriber_tax_group_id` ASC) ,
  CONSTRAINT `fk_quotation_products_sls_quotations1`
    FOREIGN KEY (`sls_quotation_id` )
    REFERENCES `cantorix_archive`.`sls_quotations` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sls_quotation_products_inv_inventories1`
    FOREIGN KEY (`inv_inventory_id` )
    REFERENCES `cantorix_archive`.`inv_inventories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sls_quotation_products_sbs_subscriber_taxes1`
    FOREIGN KEY (`sbs_subscriber_tax_id` )
    REFERENCES `cantorix_archive`.`sbs_subscriber_taxes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sls_quotation_products_sbs_subscriber_tax_groups1`
    FOREIGN KEY (`sbs_subscriber_tax_group_id` )
    REFERENCES `cantorix_archive`.`sbs_subscriber_tax_groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`sbs_subscriber_tax_group_mappings`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`sbs_subscriber_tax_group_mappings` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `priority` TINYINT NULL ,
  `sbs_subscriber_tax_id` INT NOT NULL ,
  `sbs_subscriber_tax_group_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_subscriber_tax_group_mappings_sbs_subscriber_taxes1` (`sbs_subscriber_tax_id` ASC) ,
  INDEX `fk_sbs_subscriber_tax_group_mappings_sbs_subscriber_tax_groups1` (`sbs_subscriber_tax_group_id` ASC) ,
  CONSTRAINT `fk_subscriber_tax_group_mappings_sbs_subscriber_taxes1`
    FOREIGN KEY (`sbs_subscriber_tax_id` )
    REFERENCES `cantorix_archive`.`sbs_subscriber_taxes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sbs_subscriber_tax_group_mappings_sbs_subscriber_tax_groups1`
    FOREIGN KEY (`sbs_subscriber_tax_group_id` )
    REFERENCES `cantorix_archive`.`sbs_subscriber_tax_groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`sls_quotation_custom_fields`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`sls_quotation_custom_fields` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `field_name` VARCHAR(255) NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_sls_quotation_custom_fields_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_sls_quotation_custom_fields_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`sls_quotation_custom_values`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`sls_quotation_custom_values` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data` VARCHAR(255) NULL ,
  `sls_quotation_custom_field_id` INT NOT NULL ,
  `sls_quotation_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_quotation_custom_values_sls_quotation_custom_fields1` (`sls_quotation_custom_field_id` ASC) ,
  INDEX `fk_sls_quotation_custom_values_sls_quotations1` (`sls_quotation_id` ASC) ,
  CONSTRAINT `fk_quotation_custom_values_sls_quotation_custom_fields1`
    FOREIGN KEY (`sls_quotation_custom_field_id` )
    REFERENCES `cantorix_archive`.`sls_quotation_custom_fields` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sls_quotation_custom_values_sls_quotations1`
    FOREIGN KEY (`sls_quotation_id` )
    REFERENCES `cantorix_archive`.`sls_quotations` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acr_client_invoices`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acr_client_invoices` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `invoice_number` INT NOT NULL ,
  `description` VARCHAR(255) NOT NULL ,
  `invoiced_date` DATE NOT NULL ,
  `purchase_order_no` VARCHAR(45) NULL ,
  `due_date` DATE NOT NULL ,
  `terms` VARCHAR(45) NULL ,
  `discount_percent` TINYINT NOT NULL DEFAULT 0 ,
  `status` ENUM('Draft','Open','Overdue') NULL DEFAULT 'Open' ,
  `notes` TEXT NULL ,
  `sub_total` DOUBLE NOT NULL ,
  `tax_total` DOUBLE NOT NULL ,
  `func_currency_total` DOUBLE NOT NULL COMMENT 'Application currency total amount' ,
  `exchange_rate` FLOAT NULL DEFAULT 1.0 ,
  `recurring` ENUM('Y','N') NOT NULL DEFAULT 'N' ,
  `acr_client_id` INT NOT NULL ,
  `inv_inventory_id` INT NOT NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  `invoice_total` DOUBLE NULL COMMENT 'Client currency total amount' ,
  `invoice_currency_code` VARCHAR(10) NULL COMMENT 'Client currecncy code' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_client_invoices_acr_clients1` (`acr_client_id` ASC) ,
  INDEX `fk_client_invoices_inv_inventories1` (`inv_inventory_id` ASC) ,
  INDEX `fk_acr_client_invoices_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_client_invoices_acr_clients1`
    FOREIGN KEY (`acr_client_id` )
    REFERENCES `cantorix_archive`.`acr_clients` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_client_invoices_inv_inventories1`
    FOREIGN KEY (`inv_inventory_id` )
    REFERENCES `cantorix_archive`.`inv_inventories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acr_client_invoices_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acr_invoice_details`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acr_invoice_details` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `quantity` INT NOT NULL ,
  `unit_rate` DOUBLE NOT NULL ,
  `discount_percent` TINYINT NULL ,
  `line_total` DOUBLE NOT NULL ,
  `acr_client_invoice_id` INT NOT NULL ,
  `sbs_subscriber_tax_id` INT NOT NULL ,
  `sbs_subscriber_tax_group_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_invoice_details_acr_client_invoices1` (`acr_client_invoice_id` ASC) ,
  INDEX `fk_acr_invoice_details_sbs_subscriber_taxes1` (`sbs_subscriber_tax_id` ASC) ,
  INDEX `fk_acr_invoice_details_sbs_subscriber_tax_groups1` (`sbs_subscriber_tax_group_id` ASC) ,
  CONSTRAINT `fk_invoice_details_acr_client_invoices1`
    FOREIGN KEY (`acr_client_invoice_id` )
    REFERENCES `cantorix_archive`.`acr_client_invoices` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acr_invoice_details_sbs_subscriber_taxes1`
    FOREIGN KEY (`sbs_subscriber_tax_id` )
    REFERENCES `cantorix_archive`.`sbs_subscriber_taxes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acr_invoice_details_sbs_subscriber_tax_groups1`
    FOREIGN KEY (`sbs_subscriber_tax_group_id` )
    REFERENCES `cantorix_archive`.`sbs_subscriber_tax_groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acr_invoice_custom_fields`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acr_invoice_custom_fields` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `field_name` VARCHAR(255) NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_acr_invoice_custom_fields_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_acr_invoice_custom_fields_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acr_invoice_custom_values`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acr_invoice_custom_values` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `data` VARCHAR(255) NULL ,
  `acr_client_invoice_id` INT NOT NULL ,
  `acr_invoice_custom_field_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_invoice_custom_values_acr_client_invoices1` (`acr_client_invoice_id` ASC) ,
  INDEX `fk_acr_invoice_custom_values_acr_invoice_custom_fields1` (`acr_invoice_custom_field_id` ASC) ,
  CONSTRAINT `fk_invoice_custom_values_acr_client_invoices1`
    FOREIGN KEY (`acr_client_invoice_id` )
    REFERENCES `cantorix_archive`.`acr_client_invoices` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acr_invoice_custom_values_acr_invoice_custom_fields1`
    FOREIGN KEY (`acr_invoice_custom_field_id` )
    REFERENCES `cantorix_archive`.`acr_invoice_custom_fields` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acr_client_recurring_invoices`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acr_client_recurring_invoices` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `next_invoice_date` DATE NULL ,
  `last_invoice_date` DATE NULL ,
  `invoice_start_date` DATE NULL ,
  `invoice_end_date` DATE NULL ,
  `status` ENUM('Draft','Open','Overdue') NULL ,
  `payment_cycle` ENUM('Week','Month','Year') NULL COMMENT '													' ,
  `payment_frequency` INT NULL ,
  `acr_client_invoice_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_client_recurring_invoices_acr_client_invoices1` (`acr_client_invoice_id` ASC) ,
  CONSTRAINT `fk_client_recurring_invoices_acr_client_invoices1`
    FOREIGN KEY (`acr_client_invoice_id` )
    REFERENCES `cantorix_archive`.`acr_client_invoices` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acr_invoice_payment_details`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acr_invoice_payment_details` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `payment_method` ENUM('Cash','Cheque','Credit Card','Bank Transfer','Paypal') NOT NULL ,
  `payment_date` DATE NULL ,
  `refrence_no` VARCHAR(45) NULL ,
  `notes` TEXT NULL ,
  `send_payment_note` ENUM('Y','N') NULL ,
  `acr_client_id` INT NOT NULL ,
  `acr_client_invoice_id` INT NOT NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_invoice_payment_details_acr_clients1` (`acr_client_id` ASC) ,
  INDEX `fk_invoice_payment_details_acr_client_invoices1` (`acr_client_invoice_id` ASC) ,
  INDEX `fk_acr_invoice_payment_details_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_invoice_payment_details_acr_clients1`
    FOREIGN KEY (`acr_client_id` )
    REFERENCES `cantorix_archive`.`acr_clients` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_invoice_payment_details_acr_client_invoices1`
    FOREIGN KEY (`acr_client_invoice_id` )
    REFERENCES `cantorix_archive`.`acr_client_invoices` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acr_invoice_payment_details_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acp_expense_categories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acp_expense_categories` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `category_name` VARCHAR(155) NULL ,
  `parent` INT NULL ,
  `description` TEXT NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_acp_expense_categories_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_acp_expense_categories_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acp_expenses`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acp_expenses` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `date` DATE NOT NULL ,
  `vendor_name` VARCHAR(255) NULL ,
  `amount` DOUBLE NULL ,
  `notes` TEXT NULL ,
  `reciept_upload` VARCHAR(255) NULL ,
  `is_inventory` ENUM('Y','N') NULL ,
  `acp_expense_category_id` INT NOT NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_acp_expenses_acp_expense_categories1` (`acp_expense_category_id` ASC) ,
  INDEX `fk_acp_expenses_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_acp_expenses_acp_expense_categories1`
    FOREIGN KEY (`acp_expense_category_id` )
    REFERENCES `cantorix_archive`.`acp_expense_categories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acp_expenses_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(55) NOT NULL ,
  `email` VARCHAR(155) NOT NULL ,
  `password` VARCHAR(55) NOT NULL ,
  `active` ENUM('Y','N') NOT NULL ,
  `user_type` ENUM('Super Admin','Subscriber') NOT NULL DEFAULT 'Subscriber' ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`aros`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`aros` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `parent_id` INT NULL ,
  `model` VARCHAR(55) NULL ,
  `foreign_key` INT NULL ,
  `alias` VARCHAR(155) NULL ,
  `lft` INT NULL ,
  `rght` INT NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `parent_id` INT NULL ,
  `model` VARCHAR(55) NULL ,
  `foreign_key` INT NULL ,
  `alias` VARCHAR(155) NULL ,
  `order` INT NULL ,
  `lft` INT NULL ,
  `rght` INT NULL ,
  `user_type` ENUM('Super Admin','Subscriber') NOT NULL DEFAULT 'Subscriber' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`aros_acos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`aros_acos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `aro_id` INT NOT NULL ,
  `aco_id` INT NOT NULL ,
  `_create` VARCHAR(2) NULL ,
  `_read` VARCHAR(2) NULL ,
  `_update` VARCHAR(2) NULL ,
  `_delete` VARCHAR(2) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_table1_aros1` (`aro_id` ASC) ,
  INDEX `fk_table1_acos1` (`aco_id` ASC) ,
  CONSTRAINT `fk_table1_aros1`
    FOREIGN KEY (`aro_id` )
    REFERENCES `cantorix_archive`.`aros` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_acos1`
    FOREIGN KEY (`aco_id` )
    REFERENCES `cantorix_archive`.`acos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acp_inventory_expenses`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acp_inventory_expenses` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `quantity` INT NOT NULL ,
  `cost_price` DOUBLE NOT NULL ,
  `total_amount` DOUBLE NOT NULL ,
  `func_curr_amount` DOUBLE NOT NULL COMMENT 'Application currency amount' ,
  `due_date` DATE NOT NULL ,
  `transaction_id` VARCHAR(45) NULL ,
  `inv_inventory_id` INT NOT NULL ,
  `acp_expense_id` INT NOT NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  `invoice_amount` DOUBLE NULL ,
  `invoice_currency_code` VARCHAR(10) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_inventory_expenses_inv_inventories1` (`inv_inventory_id` ASC) ,
  INDEX `fk_acp_inventory_expenses_acp_expenses1` (`acp_expense_id` ASC) ,
  INDEX `fk_acp_inventory_expenses_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_inventory_expenses_inv_inventories1`
    FOREIGN KEY (`inv_inventory_id` )
    REFERENCES `cantorix_archive`.`inv_inventories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acp_inventory_expenses_acp_expenses1`
    FOREIGN KEY (`acp_expense_id` )
    REFERENCES `cantorix_archive`.`acp_expenses` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acp_inventory_expenses_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`acr_inventory_invoices`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`acr_inventory_invoices` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `acr_client_id` INT NOT NULL ,
  `acp_inventory_expense_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_inventory_invoices_acr_clients1` (`acr_client_id` ASC) ,
  INDEX `fk_acr_inventory_invoices_acp_inventory_expenses1` (`acp_inventory_expense_id` ASC) ,
  CONSTRAINT `fk_inventory_invoices_acr_clients1`
    FOREIGN KEY (`acr_client_id` )
    REFERENCES `cantorix_archive`.`acr_clients` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acr_inventory_invoices_acp_inventory_expenses1`
    FOREIGN KEY (`acp_inventory_expense_id` )
    REFERENCES `cantorix_archive`.`acp_inventory_expenses` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`cpn_subscriber_invoice_details`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`cpn_subscriber_invoice_details` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `invoice_no` INT NOT NULL ,
  `invoiced_date` DATE NOT NULL ,
  `invoice_due_date` DATE NULL ,
  `payment_status` ENUM('Open','Overdue','Paid') NOT NULL ,
  `payment_type` ENUM('Credit Card','Paypal') NOT NULL ,
  `paid_amount` DOUBLE NULL ,
  `paid_date` DATE NULL ,
  `is_recurring` ENUM('Y','N') NULL DEFAULT 'Y' ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_subscriber_invoice_details_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_subscriber_invoice_details_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`sbs_subscriber_settings`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`sbs_subscriber_settings` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `lines_per_page` INT NULL ,
  `date_format` VARCHAR(10) NULL ,
  `direct_link` ENUM('Y','N') NULL ,
  `invoice_logo` VARCHAR(155) NULL ,
  `quote_title` VARCHAR(155) NULL ,
  `sbs_subscriber_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_subscriber_settings_sbs_subscribers1` (`sbs_subscriber_id` ASC) ,
  CONSTRAINT `fk_subscriber_settings_sbs_subscribers1`
    FOREIGN KEY (`sbs_subscriber_id` )
    REFERENCES `cantorix_archive`.`sbs_subscribers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cantorix_archive`.`cpn_user_details`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cantorix_archive`.`cpn_user_details` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(155) NULL ,
  `last_name` VARCHAR(150) NULL ,
  `profile_pic` VARCHAR(155) NULL ,
  `user_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_cpn_user_details_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_cpn_user_details_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `cantorix_archive`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
