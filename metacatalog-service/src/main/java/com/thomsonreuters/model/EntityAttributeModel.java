package com.thomsonreuters.model;

import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.exception.AppErrorException;
import com.thomsonreuters.cms.exception.AppException;
import com.thomsonreuters.datamodel.EntityAttributeDef;

import java.sql.SQLException;
import java.util.List;

public interface EntityAttributeModel {


	public List<Long> search(String searchTerm, long userId, DatabaseExecutor databaseExecutor) throws SQLException;

	public EntityAttributeDef getEntityAttributeDef(String userId, long entityAttrId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public List<EntityAttributeDef> getEntityAttributeDefList(String userId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public List<EntityAttributeDef> getEntityAttributeDefListForEntity(String userId, long entityId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;

	public long insertEntityAttribute(String userId, EntityAttributeDef entityAttrDef, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long updateEntityAttribute(String userId, EntityAttributeDef entityAttrDef, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long deleteEntityAttribute(String userId, long entityAttrId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long enableEntityAttribute(String userId, long entityAttrId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long disableEntityAttribute(String userId, long entityAttrId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;

}
