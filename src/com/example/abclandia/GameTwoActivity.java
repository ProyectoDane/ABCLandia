package com.example.abclandia;

import android.graphics.Color;
import android.graphics.drawable.GradientDrawable;
import android.os.Bundle;
import android.widget.GridView;

import com.example.abclandia.graphics.JustLetterRenderer;
import com.example.abclandia.graphics.JustWordRenderer;
import com.example.abclandia.graphics.LetterWordRenderer;
import com.frba.abclandia.R;
import com.frba.abclandia.adapters.CardViewAdapter;
import com.frba.abclandia.dragdrop.DragController;
import com.frba.abclandia.dragdrop.DragLayer;

public class GameTwoActivity extends GameActivity {
	
	public static final int TOTAL_JOINS = 5;

	private GridView mGridViewLeft;
	private GridView mGridViewRight;
	
	private static String CLASS_NAME = "com.example.abclandia.GameTwoActivity";
	private static int GAME_NUMBER = 2;
	

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
		mDragLayer.setBackgroundColor(Color.parseColor("#78EACA"));
		mDragController.setDragListener(mDragLayer);
	
		mAudio.loadLetterSoungs(data);
	
		mGridViewLeft = (GridView) findViewById(R.id.gridViewLeft);
		((GradientDrawable) mGridViewLeft.getBackground()).setColor(Color.parseColor("#F7D9A4"));
		mGridViewRight = (GridView) findViewById(R.id.gridViewRight);
		((GradientDrawable) mGridViewRight.getBackground()).setColor(Color.parseColor("#F4B1A8"));
		
		
		mGridViewLeft.setAdapter(new CardViewAdapter(data, this,
				new JustLetterRenderer(this), R.layout.game_one_card_view, false));

		mGridViewRight.setAdapter(new CardViewAdapter(data, this,
				new JustWordRenderer(this), R.layout.game_one_card_view, false));
	
		mDragLayer = (DragLayer) findViewById(R.id.drag_layer);
		mDragLayer.setDragController(mDragController);
		mDragLayer.setGridViewLeft(mGridViewLeft);
		mDragLayer.setGridViewRight(mGridViewRight);
		
		mDragController.setDragListener(mDragLayer);
		
		mDroppedRenderer = new LetterWordRenderer(this);
		mDroppedRenderer.setRectangleColorBorder(Color.GREEN);

	}
	
}
