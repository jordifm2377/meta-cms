package com.thomsonreuters.model;

import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.exception.AppErrorException;
import com.thomsonreuters.cms.exception.AppException;
import com.thomsonreuters.datamodel.AttributeDef;

import java.sql.SQLException;
import java.util.List;

public interface AttributeModel {

	public List<Long> search(String userId, String searchTerm, DatabaseExecutor databaseExecutor) throws SQLException;

	public AttributeDef getAttribute(String userId, long attrId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public List<AttributeDef> getAttributeList(String userId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;

	public long insertAttribute(String userId, AttributeDef attributeDef, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long updateAttribute(String userId, AttributeDef attributeDef, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long enableAttribute(String userId, long attrId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long disableAttribute(String userId, long attrId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public long deleteAttribute(String userId, long attrId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;

}
