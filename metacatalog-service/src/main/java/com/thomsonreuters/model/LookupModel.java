package com.thomsonreuters.model;

import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.exception.AppErrorException;
import com.thomsonreuters.cms.exception.AppException;
import com.thomsonreuters.datamodel.LookupDef;

import java.sql.SQLException;
import java.util.List;

public interface LookupModel {

	public LookupDef getLookup(String userId, long lookupId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;
	public List<LookupDef> getLookupList(String userId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException;

}
