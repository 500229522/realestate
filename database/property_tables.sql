CREATE TABLE `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `purpose` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `price` decimal(20,0) DEFAULT NULL,
  `address_line` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `postal_code` varchar(45) DEFAULT NULL,
  `area` varchar(45) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `coordinates` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_agent_id` (`agent_id`),
  KEY `FK_type_id` (`type_id`),
  CONSTRAINT `FK_agent_id` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_type_id` FOREIGN KEY (`type_id`) REFERENCES `property_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `property_amenities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `amenity_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_property_id` (`property_id`),
  KEY `FK_amenity_id` (`amenity_id`),
  CONSTRAINT `FK_amenity_id` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_property_id` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `property_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `thumbnail_path` varchar(100) DEFAULT NULL,
  `image_path` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_property_images` (`property_id`),
  CONSTRAINT `FK_property_images` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;


