package com.thomsonreuters.model;

import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.exception.AppErrorException;
import com.thomsonreuters.cms.exception.AppException;
import com.thomsonreuters.datamodel.RelationDef;

import java.sql.SQLException;
import java.util.List;

public interface RelationModel {

	public List<Long> search(String userId, String searchTerm, DatabaseExecutor databaseExecutor) throws SQLException;

	public RelationDef getRelation(String userId, long relationId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public List<RelationDef> getRelationList(String userId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;

	public long insertRelation(String userId, RelationDef relationDef, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long updateRelation(String userId, RelationDef relationDef, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long enableRelation(String userId, long relationId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long disableRelation(String userId, long relationId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long deleteRelation(String userId, long relationId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;

}
