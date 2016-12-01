package com.thomsonreuters.model;

import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.exception.AppErrorException;
import com.thomsonreuters.cms.exception.AppException;
import com.thomsonreuters.datamodel.EntityDef;

import java.sql.SQLException;
import java.util.List;

public interface EntityModel {
	
	public List<Long> search(String searchTerm, long userId, DatabaseExecutor databaseExecutor) throws SQLException;

	public EntityDef getEntity(String userId, long entityId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public List<EntityDef> getEntityList(String userId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;

	public long insertEntity(String userId, EntityDef entityDef, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long updateEntity(String userId, EntityDef entityDef, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long deleteEntity(String userId, long entityId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long enableEntity(String userId, long entityId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long disableEntity(String userId, long entityId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;


}
