package com.thomsonreuters.cms.synchronization;

import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.db.UtilsDatabase;

import java.sql.SQLException;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

// top-level static class behavior
public final class Synchronization {
	
	private static final Logger logger = LoggerFactory.getLogger("Synchronization");
	
	private static final String defaultStatus = "PENDING";
	
	private static final String actionAdd = "I";
	private static final String actionUpdate = "U";
	private static final String actionDelete = "D";
	
	private static final String track_QUERY = "INSERT INTO action_log\n" + 
		"  (action_log_id,\n" + 
		"   table_name,\n" + 
		"   table_pk_value,\n" + 
		"   action,\n" + 
		"   updated_columns,\n" + 
		"   logged_on,\n" + 
		"   back_synchronization_status)\n" + 
		"VALUES\n" + 
		"  (?,\n" + 
		"   ?,\n" + 
		"   ?,\n" + 
		"   ?,\n" + 
		"   ?,\n" + 
		"   {timestamp},\n" + 
		"   ?)";
	
	private Synchronization() {
		// private default constructor
	}
	
	private static boolean track(String tableName, long entityId, String action, String updatedColumns, DatabaseExecutor databaseExecutor) throws SQLException {
		
		SyncEntity entity = new SyncEntity();
		
		entity.setActionLogId( databaseExecutor.retrieveSequenceValue("action_log_seq") );
		
		entity.setTableName(tableName);
		entity.setTablePkValue(entityId);
		entity.setAction(action);
		entity.setUpdatedColumns(updatedColumns);
		
		entity.setBackSynchronizationStatus(defaultStatus);
		
		String query = track_QUERY;
		
		query = query.replace("{timestamp}", UtilsDatabase.SYSDATE);
		
		Object[] parameters = new Object[]{entity.getActionLogId(), entity.getTableName(), 
				entity.getTablePkValue(), entity.getAction(), entity.getUpdatedColumns(), 
				entity.getBackSynchronizationStatus() };
		
		boolean success = databaseExecutor.persistQuery(query, parameters);
		
		if (!success) {
			return false;
		}
		
		logger.trace("Sync { {} }", entity.toString());
		
		return true;
	}
	
	public static boolean trackAdd(String tableName, long entityId, DatabaseExecutor databaseExecutor) throws SQLException {
		
		return track(tableName, entityId, actionAdd, null, databaseExecutor);
	}
	
	public static boolean trackUpdate(String tableName, long entityId, String updatedColumns, DatabaseExecutor databaseExecutor) throws SQLException {
		
		return track(tableName, entityId, actionUpdate, updatedColumns.toUpperCase(), databaseExecutor);
	}
	
	public static boolean trackDelete(String tableName, long entityId, DatabaseExecutor databaseExecutor) throws SQLException {
		
		return track(tableName, entityId, actionDelete, null, databaseExecutor);
	}
}
