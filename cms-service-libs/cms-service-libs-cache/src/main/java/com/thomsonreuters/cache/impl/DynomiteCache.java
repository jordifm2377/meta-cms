package com.thomsonreuters.cache.impl;

import java.util.HashMap;
import java.util.Map;

import com.netflix.config.ConfigurationManager;
import com.netflix.config.DynamicPropertyFactory;
import com.netflix.dyno.connectionpool.HostSupplier;
import com.netflix.dyno.connectionpool.TokenMapSupplier;
import com.netflix.dyno.contrib.ArchaiusConnectionPoolConfiguration;
import com.netflix.dyno.jedis.DynoJedisClient;
import com.thomsonreuters.cache.MultiExpireCache;
import com.thomsonreuters.cache.MultiGetCache;
import com.thomsonreuters.cache.MultiPutCache;
import com.thomsonreuters.dynomite.client.config.HostSupplierFactory;
import com.thomsonreuters.dynomite.client.config.TokenMapSupplierFactory;
import com.thomsonreuters.dynomite.cluster.DynomiteClientMetadata;


public class DynomiteCache implements MultiGetCache<Object>, MultiPutCache<Object>, MultiExpireCache<Object> {

	private static class LazzyWrapper{
		static volatile DynomiteCache _instance = new DynomiteCache();

		static {
		    //register dynamic property callback
			DynamicPropertyFactory.getInstance().getStringProperty("dynomite.driver.seeds", "").addCallback(
					new Runnable() {
						@Override
						public void run() {
							refresh();
						}
					});
		}

		static void swapInstance(DynomiteCache newInstance){
			_instance = newInstance;
		}
	}
	
	public static DynomiteCache getInstance(){
		return LazzyWrapper._instance;
	}
		  
	private static void refresh(){
		LazzyWrapper.swapInstance(new DynomiteCache());
	}
		  
	private final String seeds;
	private final String cluster;
	private final String client;

	private final DynoJedisClient dynomite;
	
	private DynomiteCache(){
		//get configuration from archaius
		seeds = ConfigurationManager.getConfigInstance().getString(DynomiteClientMetadata.DYNOMITE_CLUSTER_SEEDS, ""); 
		cluster = ConfigurationManager.getConfigInstance().getString(DynomiteClientMetadata.DYNOMITE_CLUSTER_NAME,"");
	    client = ConfigurationManager.getConfigInstance().getString(DynomiteClientMetadata.DYNOMITE_CLUSTER_CLIENT_NAME,"");

	    TokenMapSupplier tokenMapSupplier = TokenMapSupplierFactory.getInstance().build(seeds);
	    HostSupplier hostSupplier = HostSupplierFactory.getInstance().build(seeds);

	    dynomite = new DynoJedisClient.Builder()
	        .withApplicationName(client)
	        .withDynomiteClusterName(cluster)
	        .withHostSupplier(hostSupplier)
	        .withCPConfig(new ArchaiusConnectionPoolConfiguration(client)
	                      .withTokenSupplier(tokenMapSupplier)
	                      .setMaxConnsPerHost(DynomiteClientMetadata.DEFAULT_DYNOMITE_CLUSTER_MAX_HOST_CONNECTION)
	            )
	        .build();
	    
	}

	@Override
	public void put(Map<String, Object> pairs) {
		
		for(String key: pairs.keySet()){
			dynomite.set(key, String.valueOf(pairs.get(key)));
		}
	}

	@Override
	public void putWithExpiration(Map<String, Object> pairs, int seconds) {

		for(String key: pairs.keySet()){
			dynomite.setex(key, seconds, String.valueOf(pairs.get(key)));
		}

	}

	@Override
	public Map<String, Object> get(String... keys) {
	    //FIXME: should be replaced by more efficient multi-get
	    Map<String, Object> result = new HashMap<String, Object>();

	    for(String key : keys){
	      result.put(key, dynomite.get(key));
	    }

	    return result;
	}

	@Override
	public void setExpiration(int seconds, String... keys) {
		for(String key: keys){
			dynomite.expire(key, seconds);
		}
		
	}
	

}
