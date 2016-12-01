package com.thomsonreuters.cms.db;

import java.io.IOException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.sql.Connection;
import java.sql.SQLException;

import javax.crypto.BadPaddingException;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;

import oracle.jdbc.pool.OracleDataSource;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public abstract class DatabaseConnectorOracle implements DatabaseConnector {
	
	private static final Logger logger = LoggerFactory.getLogger("DatabaseLibrary");
	
	private static final String database = "Oracle";
	private static final String databaseDriver = "oracle.jdbc.driver.OracleDriver";
	private static final String databaseString = "jdbc:oracle:thin:@";
	
	private String host = "";
	private String service = "";
	private String user = "";
	private String password = "";
	
    private OracleDataSource oracleDataSource;
	
	public DatabaseConnectorOracle(String host, String service, String user, String password) {
		
		this.host = host;
		this.service = service;
		this.user = user;
		this.password = password;
		
        try {
        	setupConnectionPool();
        	
        	logger.info("Database connection pool is Up & Ready!");
        } catch (BadPaddingException | IllegalBlockSizeException | InvalidKeyException | IOException | NoSuchAlgorithmException | NoSuchPaddingException e) {
        	logger.error("Database connection pool FAILED ! Password decryption error: {}", e.getMessage());
        } catch (SQLException e) {
        	logger.error("Database connection pool FAILED ! {}", e.getMessage());
        }
        
        DatabaseExecutor databaseExecutor = null;
        
        try {
        	databaseExecutor = getDatabaseExecutor(false);
        	
			UtilsDatabase.initDBTimezoneCalendar(databaseExecutor);
		} catch (SQLException e) {
			logger.error("Database connection pool retrieve FAILED! {}", e.getMessage());
		} finally {
			databaseExecutor.close();
		}
    }
	
	private void setupConnectionPool() throws BadPaddingException, IllegalBlockSizeException, InvalidKeyException, IOException, NoSuchAlgorithmException, NoSuchPaddingException, SQLException {
		
        try {
            oracleDataSource = new OracleDataSource();
            
            oracleDataSource.setURL(databaseString + host + "/" + service);
            oracleDataSource.setUser(user);
            oracleDataSource.setPassword(password);
        } finally {
			
        	logger.debug("Database: {} Driver: {} Database String: {} Host: {} Service: {} User: {}", database, databaseDriver, databaseString, host, service, user);
		}
	}
	
    @Override
    public DatabaseExecutor getDatabaseExecutor(boolean autoCommit) throws SQLException {
    	
        Connection connection;
        
    	connection = oracleDataSource.getConnection();
    	
    	connection.setAutoCommit(autoCommit);
    	
    	return new DatabaseExecutorOracleImpl(connection);
    }
    
    @Override
	public abstract String getSchema();
    
    protected String getService() {
		return user;
	};
    
	protected String getUser() {
		return user;
	};
}
