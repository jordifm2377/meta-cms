package com.thomsonreuters.cms.db;

import java.io.IOException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.sql.Connection;
import java.sql.SQLException;

import javax.crypto.BadPaddingException;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.mysql.jdbc.jdbc2.optional.MysqlDataSource;

public abstract class DatabaseConnectorMysql implements DatabaseConnector {
	
	private static final Logger logger = LoggerFactory.getLogger("DatabaseLibrary");
	
	private static final String DATABASE = "Mysql";
	private static final String DATABASE_DRIVER = "com.mysql.jdbc.Driver";
	private static final String DATABASE_STRING = "jdbc:mysql://";
	
	private String host;
	private String service;
	private String user;
	private String password;
	
    private MysqlDataSource mysqlDataSource;
	
	public DatabaseConnectorMysql(String host, String service, String user, String password) {
		
		this.host = host;
		this.service = service;
		this.user = user;
		this.password = password;
		
        try {
        	setupConnectionPool();        	
        	logger.info("Database connection pool is Up & Ready!");
        } catch (BadPaddingException | IllegalBlockSizeException | InvalidKeyException | IOException | NoSuchAlgorithmException | NoSuchPaddingException e) {
        	logger.error("Database connection pool FAILED ! Password decryption error: {}", e.getMessage(), e);
        } catch (SQLException e) {
        	logger.error("Database connection pool FAILED ! {}", e.getMessage(), e);
        }
        
    }
	
	private void setupConnectionPool() throws BadPaddingException, IllegalBlockSizeException, InvalidKeyException, IOException, NoSuchAlgorithmException, NoSuchPaddingException, SQLException {
		
        try {
        	mysqlDataSource = new MysqlDataSource();
        	
        	mysqlDataSource.setURL(DATABASE_STRING + host + "/" + service);
        	mysqlDataSource.setUser(user);
        	mysqlDataSource.setPassword(password);
        	mysqlDataSource.setAutoReconnect(true);
        	mysqlDataSource.setAutoReconnectForConnectionPools(true);
        	mysqlDataSource.setAutoReconnectForPools(true);
        } finally {			
        	logger.debug("Database: {} Driver: {} Database String: {} Host: {} Service: {} User: {}", DATABASE, DATABASE_DRIVER, DATABASE_STRING, host, service, user);
		}
	}
	
    @Override
    public DatabaseExecutor getDatabaseExecutor(boolean autoCommit) throws SQLException {
    	
        Connection connection;
    	connection = mysqlDataSource.getConnection();
    	connection.setAutoCommit(autoCommit);
    	
    	return new DatabaseExecutorMysqlImpl(connection);
    }
        
    protected String getService() {
		return user;
	}
    
	protected String getUser() {
		return user;
	}
}
