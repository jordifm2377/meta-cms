package com.thomsonreuters.cms.db;

import com.google.inject.Inject;
import com.google.inject.name.Named;

public class DatabaseConnectorMysqlImpl extends DatabaseConnectorMysql {
	
	@Inject
	public DatabaseConnectorMysqlImpl(@Named("Host") String host, 
			@Named("Service") String service, 
			@Named("User") String user, 
			@Named("Password") String password) {
		
		super(host, service, user, password);
	}
	
	@Override
	public String getSchema() {
		return getUser();
	}
}