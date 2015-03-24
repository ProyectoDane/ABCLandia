package com.frba.abclandia.utils;

import java.io.IOException;
import java.io.InputStream;

import android.content.Context;
import android.content.res.AssetManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.util.DisplayMetrics;
import android.view.View;
import android.view.WindowManager;
import android.view.animation.TranslateAnimation;

public class Util {
	
	public static Bitmap getViewBitmap(View v) {
	    v.clearFocus();
	    v.setPressed(false);

	    boolean willNotCache = v.willNotCacheDrawing();
	    v.setWillNotCacheDrawing(false);

	    // Reset the drawing cache background color to fully transparent
	    // for the duration of this operation
	    int color = v.getDrawingCacheBackgroundColor();
	    v.setDrawingCacheBackgroundColor(0);

	    if (color != 0) {
	        v.destroyDrawingCache();
	    }
	    v.buildDrawingCache();
	    Bitmap cacheBitmap = v.getDrawingCache();
	    if (cacheBitmap == null) {
//	        Log.e(TAG, "failed getViewBitmap(" + v + ")", new RuntimeException());
	        return null;
	    }

	    Bitmap bitmap = Bitmap.createBitmap(cacheBitmap);

	    // Restore the view
	    v.destroyDrawingCache();
	    v.setWillNotCacheDrawing(willNotCache);
	    v.setDrawingCacheBackgroundColor(color);

	    return bitmap;
	}
	
	public static int[] getDragViewPosition(View v) {
		int[] loc = new int[2];
	     v.getLocationOnScreen(loc);
	     return loc;
	}
	
	public static void setOriginalPositionToImageWithAnimation(View v){
		  TranslateAnimation localTranslateAnimation = new TranslateAnimation(0, 500, 0, 500);
		  localTranslateAnimation.setDuration(400);
		  localTranslateAnimation.setFillAfter(false);
		//  localTranslateAnimation.setAnimationListener(new MyAnimationListener(this));
		  v.startAnimation(localTranslateAnimation);
	}
	
	public static int getTextSizeDensityDependent(Context context, int textSize){
		
		DisplayMetrics dm = new DisplayMetrics();
		WindowManager wm = (WindowManager) context.getSystemService(Context.WINDOW_SERVICE);
        wm.getDefaultDisplay().getMetrics(dm);
        return  (int) (textSize * dm.scaledDensity); 
		
	}
	
	public static Bitmap getBitmapFromAsset(AssetManager assetManager, String strName)
    {
        InputStream istr = null;
        try {
            istr = assetManager.open(strName);
        } catch (IOException e) {
            e.printStackTrace();
        }
        Bitmap bitmap = BitmapFactory.decodeStream(istr);
        return bitmap;
    }

}
