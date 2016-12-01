package com.thomsonreuters.model;

import com.google.inject.Singleton;

import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.db.ResultObject;
import com.thomsonreuters.cms.db.RowObject;
import com.thomsonreuters.cms.exception.AppErrorException;
import com.thomsonreuters.cms.exception.AppException;
import com.thomsonreuters.datamodel.LookupDef;
import com.thomsonreuters.datamodel.RelationDef;
import com.thomsonreuters.query.Query;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@Singleton
public class LookupModelImpl implements LookupModel {
	
	private static final Logger logger = LoggerFactory.getLogger("LookupModelImpl");

	@Override
	public LookupDef getLookup(String userId, long lookupId, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
		if(lookupId <= 0)
			return null;

        Object[] parameters = new Object[]{lookupId};
        ResultObject res = databaseExecutor.retrieveQuery(Query.GET_LOOKUP, parameters);

        if(res.getRows().size() <= 0) {
        	throw new AppErrorException(AppErrorException.missingTerm);
        }
        
        logger.debug("Get lookup Id {}", lookupId);
        return parseLookupRow(res.getRows().get(0), databaseExecutor);

	}

	@Override
	public List<LookupDef> getLookupList(String userId, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
		// TODO Auto-generated method stub
		return null;
	}

	private LookupDef parseLookupRow(RowObject row, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
		LookupDef lookupDef = new LookupDef();
		lookupDef.setId((Integer) row.getRowValue().get("id"));
		lookupDef.setName((String)row.getRowValue().get("name"));
		lookupDef.setType((String)row.getRowValue().getOrDefault("type", "R"));
		lookupDef.setDefaultId((Integer) row.getRowValue().get("default_id"));

        //Lookup values
		Object[] parameters = new Object[]{lookupDef.getId()};
        ResultObject res = databaseExecutor.retrieveQuery(Query.GET_LOOKUP_VALUES, parameters);

        if(res.getRows().size() > 0) {
        	for(RowObject lookupValue : res.getRows()) {
        		long id = (Integer) lookupValue.getRowValue().get("id");
        		long order = (Integer) lookupValue.getRowValue().get("ordre");
        		String value = (String)lookupValue.getRowValue().get("value");
        		String caption = (String)lookupValue.getRowValue().get("caption");
        		lookupDef.addLookupValue(id, lookupDef.getId(), order, value, caption);
        	}
        }

		return lookupDef;
	}

}
