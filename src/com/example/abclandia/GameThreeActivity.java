package com.example.abclandia;

import android.graphics.Color;
import android.graphics.drawable.GradientDrawable;
import android.os.Bundle;
import android.widget.GridView;

import com.example.abclandia.graphics.ImageWordRenderer;
import com.example.abclandia.graphics.JustImageRenderer;
import com.example.abclandia.graphics.JustWordRenderer;
import com.frba.abclandia.R;
import com.frba.abclandia.adapters.CardViewAdapter;
import com.frba.abclandia.dragdrop.DragController;
import com.frba.abclandia.dragdrop.DragLayer;

public class GameThreeActivity extends GameActivity {
	
	public static final int TOTAL_JOINS = 5;

	private GridView mGridViewLeft;
	private GridView mGridViewRight;
	
	private static String CLASS_NAME = "com.example.abclandia.GameThreeActivity";
	private static int GAME_NUMBER = 3;
	

	/**
     * Called when the activity is first created.
     */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		
		mGameNumber = GAME_NUMBER;
		mGameClassName = CLASS_NAME;
		mTotalJoins = TOTAL_JOINS;
		super.onCreate(savedInstanceState);

		setContentView(R.layout.game_one_activity);
		mDragController = new DragController(this);
		mDragLayer = (DragLayer) findViewById(R.id.drag_layer);
		mDragLayer.setDragController(mDragController);
		mDragController.setDragListener(mDragLayer);
	
		mGridViewLeft = (GridView) findViewById(R.id.gridViewLeft);
		((GradientDrawable) mGridViewLeft.getBackground()).setColor(Color.parseColor("#C1BCED"));
		mGridViewRight = (GridView) findViewById(R.id.gridViewRight);
		((GradientDrawable) mGridViewRight.getBackground()).setColor(Color.parseColor("#D4EAB0"));
		
		mGridViewLeft.setAdapter(new CardViewAdapter(data, this,
				new JustWordRenderer(this), R.layout.game_one_card_view, true));
		mGridViewRight.setAdapter(new CardViewAdapter(data, this,
				new JustImageRenderer(this), R.layout.game_one_card_view, true));
	

		mDragLayer = (DragLayer) findViewById(R.id.drag_layer);
		mDragLayer.setDragController(mDragController);
		mDragLayer.setBackgroundColor(Color.parseColor("#F7B3A9"));
		mDragLayer.setGridViewLeft(mGridViewLeft);
		mDragLayer.setGridViewRight(mGridViewRight);
		
		mDragController.setDragListener(mDragLayer);
		
		mDroppedRenderer = new ImageWordRenderer(this);
		mDroppedRenderer.setRectangleColorBorder(Color.GREEN);

	}

}
