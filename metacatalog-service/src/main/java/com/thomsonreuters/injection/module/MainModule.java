package com.thomsonreuters.injection.module;

import com.google.inject.AbstractModule;
import com.google.inject.name.Names;
import com.google.inject.Singleton;

import com.thomsonreuters.cms.db.DatabaseConnector;
import com.thomsonreuters.cms.db.DatabaseConnectorMysqlImpl;
import com.thomsonreuters.controller.Controller;
import com.thomsonreuters.controller.Controller2;
import com.thomsonreuters.controller.ControllerImpl;
import com.thomsonreuters.controller.ControllerImpl2;
import com.thomsonreuters.model.AttributeModel;
import com.thomsonreuters.model.AttributeModelImpl;

import java.io.IOException;
import java.util.Properties;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class MainModule extends AbstractModule {
	
	private static final Logger logger = LoggerFactory.getLogger("DiseaseService");
	
	private static final String PROPERTY_HOST = "host";
	private static final String PROPERTY_SERVICE = "service";
	private static final String PROPERTY_USER = "user";
	private static final String PROPERTY_PASSWORD = "password";
			
	@Override
	protected void configure() {
		
		// Guice bindings
		bind(Controller.class).to(ControllerImpl.class).in(Singleton.class);
		bind(Controller2.class).to(ControllerImpl2.class).in(Singleton.class);
		//bind(AttributeModel.class).to(AttributeModelImpl.class).in(Singleton.class);
		
        // Reading from properties file
		Properties properties = new Properties();
		try {
			properties.load(getClass().getClassLoader().getResourceAsStream("database.properties"));			
			logger.info("Database properties file read");
		} catch (IOException e) {
			logger.error("Failed to read the database properties file! Loading defaults... {}", e.getMessage(), e);
		}
		
		bind(String.class).annotatedWith(Names.named("Host")).toInstance(properties.getProperty(PROPERTY_HOST, ""));
		
		bind(String.class).annotatedWith(Names.named("Service")).toInstance(properties.getProperty(PROPERTY_SERVICE, ""));
		bind(String.class).annotatedWith(Names.named("User")).toInstance(properties.getProperty(PROPERTY_USER, ""));
		bind(String.class).annotatedWith(Names.named("Password")).toInstance(properties.getProperty(PROPERTY_PASSWORD, ""));
		
		// Single connection for queries
		bind(DatabaseConnector.class).to(DatabaseConnectorMysqlImpl.class).in(Singleton.class);
		
		logger.info("Google Guice Dependency Injection OK");
	}
}
